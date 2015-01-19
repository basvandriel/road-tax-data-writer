<?php

    require_once "../src/Bas/RoadTaxDataParser/Parser/Parser.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatterDataWriter/FormattedDataWriter.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatConverter/FormatConverterHandler.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatConverter/FormatConverter.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatConverter/FormatConverters/DeliveryVanDisabledFormatConverter.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatConverter/FormatConverters/MotorcycleFormatConverter.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatConverter/FormatConverters/PassengerCarFormatConverter.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatConverter/FormatConverters/CampingCarFormatConverter.php";
    require_once "../src/Bas/RoadTaxDataParser/FormatConverter/FormatConverters/BusFormatConverter.php";

    $root = dirname(__DIR__);

    $parser = new \Bas\RoadTaxDataParser\Parser\Parser("{$root}\\var\\data.json");
    $data   = $parser->parse();

    $formatter        = new \Bas\RoadTaxDataParser\FormatConverter\FormatConverterHandler((array)$data);
    $formatConverters = $formatter->resolveFormatConverters();
    $formattedData    = $formatter->convertFormat($formatConverters);

    $formattedDataWriter = new \Bas\RoadTaxDataParser\FormatterDataWriter\FormattedDataWriter($formattedData);
    $formattedDataWriter->saveFiles("{$root}\\var");