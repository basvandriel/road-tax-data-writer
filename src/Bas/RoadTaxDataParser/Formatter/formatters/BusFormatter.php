<?php

    namespace Bas\RoadTaxDataParser\Formatter\Formatters;

    use Bas\RoadTaxDataParser\Formatter\Formatter;

    class BusFormatter implements Formatter
    {
        /**
         * @param array $data The data which is getting formatted
         *
         * @return mixed
         */
        public function format(array $data) {
            // TODO: Implement format() method.
            $data = $data->dataAutobus;

            $formatted = [];

            for ($dataIndex = 0; $dataIndex < count($data); $dataIndex++) {

            }
        }
    }