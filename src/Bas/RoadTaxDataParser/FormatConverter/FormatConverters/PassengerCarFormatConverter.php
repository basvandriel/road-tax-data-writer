<?php

    namespace Bas\RoadTaxDataParser\FormatConverter\FormatConverters;

    use Bas\RoadTaxDataParser\FormatConverter\FormatConverter;

    class PassengerCarFormatConverter implements FormatConverter
    {

        /**
         * @param array $resolvedData The data which is getting formatted
         *
         * @return mixed
         */
        public function convert(array $resolvedData) {
            $formatted = [];
            foreach ($resolvedData as $provinceName => $provinceData) {
                $provinceDataRows = count($provinceData);
                for ($provinceDataRowIndex = 0; $provinceDataRowIndex < $provinceDataRows; $provinceDataRowIndex++) {
                    $formatted[$provinceName][$provinceData[$provinceDataRowIndex][0]] = array(
                        "benzine"          => (int)$provinceData[$provinceDataRowIndex][1],
                        "diesel"           => (int)$provinceData[$provinceDataRowIndex][2],
                        "lpg3_natural_gas" => (int)$provinceData[$provinceDataRowIndex][3],
                        "lpg_others"       => (int)$provinceData[$provinceDataRowIndex][4],
                    );
                }
            }
            return $formatted;
        }

        /**
         * @param array $data
         *
         * @return array
         */
        public function resolveData(array $data) {
            return array(
                'zeeland'       => $data['dataZL'],
                'noord_holland' => $data['dataNH'],
                'noord_brabant' => $data['dataNB'],
                'limburg'       => $data['dataLI'],
            );
        }
    }