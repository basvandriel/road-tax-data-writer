<?php

    /**
     *
     */
    namespace Bas\RoadTaxDataParser\Formatter\Formatters;

    /**
     *
     */
    use Bas\RoadTaxDataParser\Formatter\Formatter;

    /**
     * Class BusFormatter
     *
     * @package Bas\RoadTaxDataParser\Formatter\Formatters
     */
    class BusFormatter implements Formatter
    {
        /**
         * @param array $resolvedResolvedData
         *
         * @return array
         */
        public function format(array $resolvedResolvedData) {
            $formatted = [];
            for ($i = 0; $i < count($resolvedResolvedData); $i++) {
                $formatted[(int)$resolvedResolvedData[$i][0]] = [
                    'quarterly' => (int)$resolvedResolvedData[$i][1],
                    'yearly'    => (int)$resolvedResolvedData[$i][2]
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