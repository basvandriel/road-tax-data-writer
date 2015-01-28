<?php
    /**
     *
     */

    namespace Bas\RoadTaxDataWriter\FormatConverter\FormatConverters;


    use Bas\RoadTaxDataWriter\FormatConverter\FormatConverter;

    class DeliveryVanFormatConverter implements FormatConverter
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
            foreach ($resolvedData as $genre => $data) {
                $dataLength = count($data);
                for ($i = 0; $i < $dataLength; $i++) {
                    if ($genre === "passenger") {
                        $convertedFormatData[$genre][$data[$i][0]] = [
                            "benzine"          => (int)$data[$i][1],
                            "diesel"           => (int)$data[$i][2],
                            "lpg3_natural_gas" => (int)$data[$i][3],
                            "lpg_others"       => (int)$data[$i][4],
                        ];
                    } else {
                        $convertedFormatData[$genre][$data[$i][0]] = [
                            "quarterly" => (int)$data[$i][1],
                            "yearly"    => (int)$data[$i][2]
                        ];
                    }
                }
            }
            return $convertedFormatData;
        }

        /**
         * Resolves the resolvedData in a resolvedData map or single array and returns it.
         *
         * @param $data array All the non-formatted resolvedData
         *
         * @return array $resolvedData The resolvedData resolved for this vehicle type as an single array or
         *                       resolvedData-map
         */
        public function resolveData(array $data) {
            return [
                "passenger"  => $data["dataBAP"],
                "disabled"   => $data["dataBAI"],
                "commercial" => $data["dataBAZ"]
            ];
        }
    }