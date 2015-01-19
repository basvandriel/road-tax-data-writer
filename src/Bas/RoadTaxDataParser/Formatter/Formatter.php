<?php

    namespace Bas\RoadTaxDataParser\Formatter;

    /**
     * Class FormatConverters
     */
    class Formatter
    {
        /**
         * @var array $data The parsed data
         */
        private $data;

        /**
         * Instantiates a new data formatter
         *
         * @param array $data The parsed data
         */
        public function __construct(array $data) {
            $this->data = $data;
        }

        /**
         * Converts the standard format on every vehicle type based on the format converter classes
         *
         * @param array $formatConverterClasses Every located formatter class with it's file name
         *
         * @return array
         */
        public function convertFormat(array $formatConverterClasses) {
            $convertedFormatData = [];
            foreach ($formatConverterClasses as $fileName => $formatConverterClass) {
                $reflectedFormatConverterClass = new \ReflectionClass($formatConverterClass);
                if ($reflectedFormatConverterClass->isInstantiable() && $reflectedFormatConverterClass->isSubclassOf(dirname($this->getNamespace()) . "\\Formatter\\FormatConverter")) {
                    /**
                     * @type FormatConverter $instance
                     */
                    $instance                       = $reflectedFormatConverterClass->newInstance();
                    $resolvedData                   = $instance->resolveData((array)$this->data);
                    $convertedFormatData[$fileName] = $instance->convert($resolvedData);
                }
            }
            return $convertedFormatData;
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
         * Resolves every location of the format converter classes and put's them in a array with a file name.
         */
        public function resolveFormatConverters() {
            $formatConverterClasses = [];
            $inputDirectory         = __DIR__ . "\\..\\Formatter\\FormatConverters";
            foreach (new \DirectoryIterator($inputDirectory) as $file) {
                if ($file->isDot()) {
                    continue;
                }
                $formatConverterClassName                                           = dirname($this->getNamespace()) . "\\Formatter\\FormatConverters\\" . $file->getBasename(".php");
                $formatConverterClasses[$file->getBasename("FormatConverters.php")] = $formatConverterClassName;
            }
            return $formatConverterClasses;
        }
    }