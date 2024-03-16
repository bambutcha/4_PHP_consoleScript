<?php

$params = $argv;
array_shift($params);
main($params);

function main(array $params) {
    $inputFileName       = $params[0];
    $outputDirectoryName = $params[1] ?? 'output';

    $inputFileData = file($inputFileName);
    $headers       = array_shift($inputFileData);

    $handledInputData = [];
    foreach ($inputFileData as $inputEntity) {
        $tmp = explode(',', $inputEntity);

        $handledInputData[] = array_map('prepare_entity_column', $tmp);
    }

    $saintWordEntities = array_filter(
        $handledInputData,
        'is_entity_contains_saint_word'
    );

    $sameCharacterCityCountry = array_filter(
        $handledInputData,
        'is_city_country_same_character'
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

