<?php

    /*!
     * The MIT License (MIT)
     *
     * Copyright (c) 2014 Bas van Driel
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
     * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
     * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
     * permit persons to whom the Software is furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
     * Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
     * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
     * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
     * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
     */
    namespace Bas\RoadTaxDataParser\Parser;

    use Bas\RoadTaxDataParser\FormaterConverter\FormatConverter;

    /**
     * Class Parser
     *
     * @package Bas\RoadTaxDataParser\Parser
     */
    class Parser
    {

        /**
         * @var string $uri The location of the data file
         */
        private $uri;

        /**
         *
         * @param string $uri The location of the data file
         */
        public function __construct($uri) {
            $this->uri = $uri;
        }

        public function parse() {
            $data = json_decode(file_get_contents($this->uri));
            foreach ($data as $vehicleTypeKey => $values) {
                for ($i = 0; $i < count($values); $i++) {
                    $data->{$vehicleTypeKey}[$i] = explode("#", $values[$i]);
                }
            }
            return $data;
        }

        /**
         * Formats the data based on all located formatter classes
         *
         * @param array $formatterClasses Every found formatter class
         *
         * @return array The formatted data
         */
        public function formatData(array $formatterClasses) {
            $formattedDataArrays = [];
            $data = json_decode(file_get_contents($this->uri));


            foreach ($data as $vehicleTypeKey => $values) {
                for ($i = 0; $i < count($values); $i++) {
                    $data->{$vehicleTypeKey}[$i] = explode("#", $values[$i]);
                }
            }

            foreach ($formatterClasses as $fileName => $formatterClass) {
                $reflectedClass = new \ReflectionClass($formatterClass);
                if ($reflectedClass->isInstantiable() && $reflectedClass->isSubclassOf(dirname($this->getNamespace()) . "\\FormatConverters\\FormatConverters")) {
                    /**
                     * @type FormatConverter $instance
                     */
                    $instance                       = $reflectedClass->newInstance();
                    $resolvedData                   = $instance->resolveData((array)$data);
                    $formattedDataArrays[$fileName] = $instance->format($resolvedData);
                }
            }
            return $formattedDataArrays;
        }

        /**
         * @return string The namespace of this file
         */
        private function getNamespace() {
            return substr($this->getClass(), 0, strrpos($this->getClass(), "\\"));
        }

        /**
         * @return string The class name of this class
         */
        private function getClass() {
            return get_class($this);
        }

        /**
         * Resolves the locations of the formatter classes
         *
         * @return array The locations of the formatter classes with the file name they should use to print out an php
         *               file
         */
        public function locateFormatterClasses() {
            $inputDirectory = __DIR__ . "\\..\\FormatConverters\\FormatConverters";
            $formatterClasses = [];
            foreach (new \DirectoryIterator($inputDirectory) as $file) {
                if ($file->isDot()) {
                    continue;
                }
                $formatterClassName                                           = dirname($this->getNamespace()) . "\\FormatConverters\\FormatConverters\\" . $file->getBasename(".php");
                $formatterClasses[$file->getBasename("FormatConverters.php")] = $formatterClassName;
            }
            return $formatterClasses;
        }
    }