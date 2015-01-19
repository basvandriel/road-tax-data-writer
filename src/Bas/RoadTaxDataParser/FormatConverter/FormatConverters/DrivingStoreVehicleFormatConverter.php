<?php
    /**
     *
     */

    namespace Bas\RoadTaxDataParser\FormatConverter\FormatConverters;


    use Bas\RoadTaxDataParser\FormatConverter\FormatConverter;

    class DrivingStoreVehicleFormatConverter implements FormatConverter
    {

        /**
         * Converts the format for the inputted (resolved) resolvedData for the specific vehicle type
         *
         * @param $resolvedData         array The resolved resolvedData The resolvedData resolved for this vehicle type
         *                              as an single array or resolvedData-map which is getting formatted
         *
         * @throws \HttpRequestException When it cant find the resolvedData
         *
         * @return array The resolvedData which it's format has been converted
         */
        public function convert(array $resolvedData) {
            $convertedFormatData = [];
            for ($i = 0; $i < count($resolvedData); $i++) {
                $convertedFormatData[(int)$resolvedData[$i][0]] = [
                    'quarterly' => (int)$resolvedData[$i][1],
                    'yearly'    => (int)$resolvedData[$i][2]
                ];
            }
            return $convertedFormatData;
        }

        /**
         * Resolves the resolvedData in a resolvedData map or single array and returns it.
         *
         * @param $data array All the non-formatted resolvedData
         *
         * @return $resolvedData array The resolvedData resolved for this vehicle type as an single array or
         *                       resolvedData-map
         */
        public function resolveData(array $data) {
            return $data["dataWinkelwagen"];
        }
    }