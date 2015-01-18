<?php


    /**
     *
     */
    namespace Bas\RoadTaxDataParser\Formatter\FormatConverters;


    use Bas\RoadTaxDataParser\Formatter\FormatConverter;

    /**
     * Class CampingCarFormatConverter
     *
     * @package Bas\RoadTaxDataParser\FormatConverters\FormatConverters
     */
    class CampingCarFormatConverter implements FormatConverter
    {

        /**
         * @param array $resolvedData The data which is getting formatted
         *
         * @return mixed
         */
        public function format(array $resolvedData) {
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
                    'zeeland'       => $data["data_0_ZL"],
                    'noord_holland' => $data["data_0_NH"]
                ),
                false => array(
                    'zeeland'       => $data["data_1_ZL"],
                    'noord_holland' => $data["data_1_NH"]
                ),
            ];
        }
    }