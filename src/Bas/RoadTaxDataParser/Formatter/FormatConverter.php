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
    namespace Bas\RoadTaxDataParser\Formatter;

    /**
     * Interface FormatConverters
     *
     * @package Bas\RoadTaxDataParser\FormatConverters\
     */
    interface FormatConverter
    {
        /**
         * Converts the inputted resolved data for the specific vehicle type
         *
         * @param $resolvedData array The resolved data The data resolved for this vehicle type as an single array or
         *                      data-map which is getting formatted
         *
         * @throws \HttpRequestException When it cant find the data
         *
         * @return array The data which it's format has been converted
         */
        public function convert(array $resolvedData);

        /**
         * Resolves the data in a data map or single array and returns it.
         *
         * @param $data array All the non-formatted data
         *
         * @return $data array The data resolved for this vehicle type as an single array or data-map
         */
        public function resolveData(array $data);
    }