<?php

    require_once "src/Bas/RoadTaxDataParser/FormatterDataWriter/FormattedDataWriter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/Formatter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/Formatters/PassengerCarFormatter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/Formatters/CampingCarFormatter.php";
    require_once "src/Bas/RoadTaxDataParser/Formatter/Formatters/BusFormatter.php";
    require_once "src/Bas/RoadTaxDataParser/Parser/Parser.php";

    $parser           = new \Bas\RoadTaxDataParser\Parser\Parser(__DIR__ . "\\var\\data.json");
    $formatterClasses = $parser->locateFormatterClasses();
    $formattedData    = $parser->formatData($formatterClasses);

    $formattedDataWriter = new \Bas\RoadTaxDataParser\FormatterDataWriter\FormattedDataWriter($formattedData);
    $formattedDataWriter->saveFiles(__DIR__ . "\\var");