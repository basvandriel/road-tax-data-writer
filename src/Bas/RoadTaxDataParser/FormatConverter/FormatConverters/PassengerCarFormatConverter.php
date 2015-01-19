<?php

    namespace Bas\RoadTaxDataParser\FormatConverter\FormatConverters;

    use Bas\RoadTaxDataParser\FormatConverter\FormatConverter;

    class PassengerCarFormatConverter implements FormatConverter
    {

        /**
         * @param array $resolvedData The resolvedData which is getting formatted
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
                'noord_holland' => $data["dataNH"],
                'utrecht'       => $data["dataUT"],
                'noord_brabant' => $data["dataNB"],
                'flevoland'     => $data["dataFL"],
                'limburg'       => $data["dataLI"],
                'zeeland'       => $data["dataZL"],
                'overrijsel'    => $data["dataOV"],
                'groningen'     => $data["dataGR"],
                'gelderland'    => $data["dataGL"],
                'drenthe'       => $data["dataDR"],
                'friesland'     => $data["dataFR"],
                'zuid_holland'  => $data["dataZH"],
            );
        }
    }