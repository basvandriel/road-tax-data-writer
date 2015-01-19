<?php
    namespace Bas\RoadTaxDataParser\FormatConverter\FormatConverters;


    use Bas\RoadTaxDataParser\FormatConverter\FormatConverter;

    class MotorcycleFormatConverter implements FormatConverter
    {

        /**
         * Converts the format for the inputted (resolved) data for the specific vehicle type
         *
         * @param $data array The resolved data The data resolved for this vehicle type as an single array or
         *                      data-map which is getting formatted
         *
         * @throws \HttpRequestException When it cant find the data
         *
         * @return array The data which it's format has been converted
         */
        public function convert(array $data) {
            $convertedFormatData = [];
            for ($i = 0; $i < count($data); $i++) {
                $provinceName                       = strtolower(str_replace("-", "_", (string)$data[$i][0]));
                $convertedFormatData[$provinceName] = [
                    'quarterly' => (int)$data[$i][1],
                    'yearly'    => (int)$data[$i][2]
                ];
            }
            return $convertedFormatData;
        }

        /**
         * Resolves the data in a data map or single array and returns it.
         *
         * @param $data array All the non-formatted data
         *
         * @return $data array The data resolved for this vehicle type as an single array or data-map
         */
        public function resolveData(array $data) {
            return $data["dataMotor"];
        }
    }