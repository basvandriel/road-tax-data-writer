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

    /**
     * This class is ment to parse data in an array and convert the standard format to a 3D php array
     *
     * @package   Bas\RoadTaxDataParser\Parser
     *
     * @author    Bas van Driel <basvandriel94@gmail.com>
     * @copyright 2014 Bas van Driel
     * @license   MIT
     */
    class Parser
    {

        /**
         * @var string $uri The location of the data file
         */
        private $uri;

        /**
         * Instantiates a new data parser
         *
         * @param string $uri The location of the data file
         */
        public function __construct($uri) {
            $this->uri = $uri;
        }

        /**
         * Parses the data from the inputted JSON file into an array and then converts the standard format.
         *
         * @return array The parsed and converted data in array format
         */
        public function parse() {
            $data = json_decode(file_get_contents($this->uri));
            foreach ($data as $vehicleTypeKey => $values) {
                for ($i = 0; $i < count($values); $i++) {
                    $data->{$vehicleTypeKey}[$i] = explode("#", $values[$i]);
                }
            }
            return $data;
        }
    }