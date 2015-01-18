<?php

    require_once "src/Bas/RoadTaxDataParser/Parser/Parser.php";
    require_once "src/Bas/RoadTaxDataParser/FormatterDataWriter/FormattedDataWriter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/Formatter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/FormatConverter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/FormatConverters/PassengerCarFormatConverter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/FormatConverters/CampingCarFormatConverter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/FormatConverters/BusFormatConverter.php";

    $root = __DIR__;

    $parser = new \Bas\RoadTaxDataParser\Parser\Parser("{$root}\\var\\data.json");
    $data   = $parser->parse();

    $formatter        = new \Bas\RoadTaxDataParser\Formatter\Formatter((array)$data);
    $formatConverters = $formatter->resolveFormatConverters();
    $formattedData    = $formatter->convertFormat($formatConverters);

    $formattedDataWriter = new \Bas\RoadTaxDataParser\FormatterDataWriter\FormattedDataWriter($formattedData);
    $formattedDataWriter->saveFiles("{$root}\\var");