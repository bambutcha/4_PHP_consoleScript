<?php

const DEFAULT_OUTPUT_FORMAT   = 'csv';
const DEFAULT_OUTPUT_DIR_NAME = 'output';

const HEADERS_DATA_KEY     = 'headers';
const ENTITY_LIST_DATA_KEY = 'entity_list';

$params = $argv;
array_shift($params);
main($params);

function main(array $params) {
    $inputFileName       = $params[0];
    $outputFileFormat    = $params[2] ?? DEFAULT_OUTPUT_FORMAT;
    $outputDirectoryName = $params[1] ?? DEFAULT_OUTPUT_DIR_NAME;

    $inputData  = handle_input_file($inputFileName);
    $entityList = $inputData[ENTITY_LIST_DATA_KEY];
    write_entity_count('input_data', $entityList, true);

    $saintWordEntities = get_needle_by_filtration($entityList, 'is_entity_contains_saint_word');
    $sameCharacterCityCountry = get_needle_by_filtration($entityList, 'is_city_country_same_character');
    $entityList = [
        'is_entity_contains_saint_word'  => $saintWordEntities,
        'is_city_country_same_character' => $sameCharacterCityCountry,
    ];

    prepare_dir($outputDirectoryName);
    foreach ($entityList as $outputName => $entity) {
        $outputPath = implode(DIRECTORY_SEPARATOR, [$outputDirectoryName, $outputName]);

        array_unshift($entity, $inputData[HEADERS_DATA_KEY]);
        write_file_data($entity, $outputPath, $outputFileFormat);
        write_entity_count($outputName, $entity);
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

function get_needle_by_filtration(array $haystack, string $filtrationFunction): array {
    return array_filter($haystack, $filtrationFunction);
}

function write_file_data(array $data, string $fileName, string $format): void {
    $outputFile = fopen("$fileName.$format", 'w');

    foreach ($data as $entity) {
        fputcsv($outputFile, $entity);
    }
}

function write_entity_count(string $key, array $data, bool $shouldCleanUp = false): void {
    $data = $key . ' => ' . count($data);

    if ($shouldCleanUp) {
        file_put_contents('counter.txt', $data);
        return;
    }

    file_put_contents('counter.txt', PHP_EOL . $data, FILE_APPEND);
}

function prepare_dir(string $dirName): bool {
    return mkdir($dirName);
}

function handle_input_file(string $filePath): array {
    $inputFileData = file($filePath);
    $headers       = array_shift($inputFileData);

    $handledInputData = [];
    foreach ($inputFileData as $inputEntity) {
        $handledInputData[] = handle_input_entity($inputEntity);
    }

    return [
        HEADERS_DATA_KEY     => handle_input_entity($headers),
        ENTITY_LIST_DATA_KEY => $handledInputData,
    ];
}

function handle_input_entity(string $inputEntity): array {
    return array_map(
        'prepare_entity_column',
        explode(',', $inputEntity)
    );
}