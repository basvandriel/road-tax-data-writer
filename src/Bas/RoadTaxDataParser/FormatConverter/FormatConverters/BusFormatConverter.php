<?php

    /**
     *
     */
    namespace Bas\RoadTaxDataParser\FormatConverter\FormatConverters;

    use Bas\RoadTaxDataParser\FormatConverter\FormatConverter;


    /**
     * Class BusFormatConverter
     *
     * @package Bas\RoadTaxDataParser\FormatConverters\FormatConverters
     */
    class BusFormatConverter implements FormatConverter
    {
        /**
         * @param array $resolvedData
         *
         * @return array
         */
        public function convert(array $resolvedData) {
            $formatted = [];
            for ($i = 0; $i < count($resolvedData); $i++) {
                $formatted[(int)$resolvedData[$i][0]] = [
                    'quarterly' => (int)$resolvedData[$i][1],
                    'yearly'    => (int)$resolvedData[$i][2]
                ];
            }
            return $formatted;
        }

        /**
         * @param array $data
         *
         * @return array
         */
        public function resolveData(array $data) {
            return $data['dataAutobus'];
        }
    }