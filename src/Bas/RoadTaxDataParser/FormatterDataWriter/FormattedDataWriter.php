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
    namespace Bas\RoadTaxDataParser\FormatterDataWriter;


    /**
     * Writes the formatted data per vehicle type to php files in array (< 5.4) format
     *
     * @package Bas\RoadTaxDataParser\FormattedDataWriter
     */
    class FormattedDataWriter
    {
        /**
         * @var $formattedData array The formatted data with it's file name
         */
        private $formattedData;

        /**
         * Instantiates a new FormattedDataWriter
         *
         * @param $formattedData   array The formatted data with it's file name
         */
        public function __construct(array $formattedData) {
            $this->formattedData = $formattedData;
        }

        /**
         * Saves the formatted data to the specified output directory in it's given filename
         *
         * @param $outputDirectory string The location where the files are getting stored
         */
        public function saveFiles($outputDirectory) {
            foreach ($this->formattedData as $fileName => $formattedDataRow) {
                $data = var_export($formattedDataRow, true);
                file_put_contents("{$outputDirectory}\\{$fileName}", "<?php\n\n return {$data};");
            }
        }
    }