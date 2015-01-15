<?php

    namespace Bas\RoadTaxDataParser\Formatter;

    /**
     * Interface Formatter
     *
     * @package Bas\RoadTaxDataParser\Formatter\
     */
    interface Formatter
    {
        /**
         * @param array $data The data which is getting formatted
         *
         * @return mixed
         */
        public function format(array $data);
    }