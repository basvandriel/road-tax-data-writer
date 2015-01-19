<?php


    /**
     *
     */
    namespace Bas\RoadTaxDataWriter\FormatConverter\FormatConverters;


    use Bas\RoadTaxDataWriter\FormatConverter\FormatConverter;

    /**
     * Class CampingCarFormatConverter
     *
     * @package Bas\RoadTaxDataWriter\FormatConverters\FormatConverters
     */
    class CampingCarFormatConverter implements FormatConverter
    {

        /**
         * @param array $resolvedData The resolvedData which is getting formatted
         *
         * @return mixed
         */
        public function convert(array $resolvedData) {
            $formatted = [];
            foreach ($resolvedData as $isRented => $provinces) {
                foreach ($provinces as $provinceName => $provinceData) {
                    $provinceDataRows = count($provinceData);
                    for ($provinceDataIndex = 0; $provinceDataIndex < $provinceDataRows; $provinceDataIndex++) {
                        $formatted[$isRented][$provinceName][$provinceData[(int)$provinceDataIndex][0]] = array(
                            "benzine"          => (int)$provinceData[$provinceDataIndex][1],
                            "diesel"           => (int)$provinceData[$provinceDataIndex][2],
                            "lpg3_natural_gas" => (int)$provinceData[$provinceDataIndex][3],
                            "lpg_others"       => (int)$provinceData[$provinceDataIndex][4],
                        );
                    }
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
            return [
                true  => array(
                    'noord_holland' => $data["data_1_NH"],
                    'utrecht'       => $data["data_1_UT"],
                    'noord_brabant' => $data["data_1_NB"],
                    'flevoland'     => $data["data_1_FL"],
                    'limburg'       => $data["data_1_LI"],
                    'zeeland'       => $data["data_1_ZL"],
                    'overrijsel'    => $data["data_1_OV"],
                    'groningen'     => $data["data_1_GR"],
                    'gelderland'    => $data["data_1_GL"],
                    'drenthe'       => $data["data_1_DR"],
                    'friesland'     => $data["data_1_FR"],
                    'zuid_holland'  => $data["data_1_ZH"],
                ),
                false => array(
                    'noord_holland' => $data["data_0_NH"],
                    'utrecht'       => $data["data_0_UT"],
                    'noord_brabant' => $data["data_0_NB"],
                    'flevoland'     => $data["data_0_FL"],
                    'limburg'       => $data["data_0_LI"],
                    'zeeland'       => $data["data_0_ZL"],
                    'overrijsel'    => $data["data_0_OV"],
                    'groningen'     => $data["data_0_GR"],
                    'gelderland'    => $data["data_0_GL"],
                    'drenthe'       => $data["data_0_DR"],
                    'friesland'     => $data["data_0_FR"],
                    'zuid_holland'  => $data["data_0_ZH"],
                ),
            ];
        }
    }