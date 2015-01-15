<?php

    $parser            = new \Bas\RoadTaxDataParser\Parser\Parser('var/data.json');
    $formattersClasses = $parser->locateFormatterClasses();
    $formattedData     = $parser->formatData($formattersClasses);
    $parser->saveFiles($formattedData);