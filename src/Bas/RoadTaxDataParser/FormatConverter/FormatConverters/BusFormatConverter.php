<?php

    /**
     *
     */
    namespace Bas\RoadTaxDataParser\FormatConverter\FormatConverters;

    /**
     * Import the FormatConverter interface for usage
     */
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
            $convertedFormatData = [];
            for ($resolvedDataIndex = 0; $resolvedDataIndex < count($resolvedData); $resolvedDataIndex++) {
                $convertedFormatData[(int)$resolvedData[$resolvedDataIndex][0]] = [
                    'quarterly' => (int)$resolvedData[$resolvedDataIndex][1],
                    'yearly'    => (int)$resolvedData[$resolvedDataIndex][2]
                ];
            }
            return $convertedFormatData;
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