<?php

$params = $argv;
array_shift($params);
main($params);

function main(array $params) {
    $inputFileName       = $params[0];
    $outputDirectoryName = $params[1] ?? 'output';

    $inputFileData = file($inputFileName);
    $headers       = array_shift($inputFileData); // Убрали вехнюю нажпись, засунув ее в переменную

    $handledInputData = [];
    foreach ($inputFileData as $inputEntity) {
        $tmp = explode(',', $inputEntity); // исключаем из данных запятые

        $handledInputData[] = array_map('prepare_entity_column', $tmp); // Применяем функцию,
                                                                                // которая убирает все ковычки
    }

    $saintWordEntities = array_filter(
        $handledInputData,
        'is_entity_contains_saint_word'
    );

    $sameCharacterCityCountry = array_filter(
        $handledInputData,
        'is_city_country_same_character'
    );

    $asiancity = array_filter(
        $handledInputData,
        'is_this_an_asian_city'
    );

    mkdir($outputDirectoryName);

    $outputFile = fopen("$outputDirectoryName/saint_word_entities.csv", 'w');
    foreach ($saintWordEntities as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/same_character_city_country.csv", 'w');
    foreach ($sameCharacterCityCountry as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/asian_city.csv", 'w');
    foreach ($asiancity as $entity) {
        fputcsv($outputFile, $entity);
    }
}

function is_entity_contains_saint_word(array $entity): bool {
    return stripos($entity[0], 'saint');
}

function is_city_country_same_character(array $entity): bool {
    return substr($entity[0], 0, 1) == substr($entity[3], 0, 1);
}

function prepare_entity_column(string $value): string {
    return trim($value, '"' . PHP_EOL);
}

function is_this_an_asian_city(array $entity): bool {
    $lat_east   = 66.05;
    $lng_east   = 169.4;
    $lat_north  = 77.43;
    $lng_north  = 104.18;
    $lat_west   = 39.29;
    $lng_west   = 26.04;
    $lat_south  = 1.16;
    $lng_south  = 103.30;

    $lat = (float)$entity[1];
    $lng = (float)$entity[2];

    if (($lat_north >= $lat) && ($lat >= $lat_south)) {
        if (($lng_east >= $lng) && ($lng >= $lng_west)) {
            return true;
        }
    }

    return false;
}

