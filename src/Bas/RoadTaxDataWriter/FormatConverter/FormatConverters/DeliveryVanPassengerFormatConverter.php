<?php
    /**
     *
     */

    namespace Bas\RoadTaxDataWriter\FormatConverter\FormatConverters;


    use Bas\RoadTaxDataWriter\FormatConverter\FormatConverter;

    class DeliveryVanPassengerFormatConverter implements FormatConverter
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
                $convertedFormatData[(string)$resolvedData[$i][0]] = [
                    'benzine'          => (int)$resolvedData[$i][1],
                    'diesel'           => (int)$resolvedData[$i][2],
                    'lpg3_natural_gas' => (int)$resolvedData[$i][3],
                    'lpg_others'       => (int)$resolvedData[$i][4]
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
            return $data["dataBAP"];
        }
    }