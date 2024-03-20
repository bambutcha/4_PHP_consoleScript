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

    $asianCity = array_filter(
        $handledInputData,
        'is_this_an_asian_city'
    );

    $asiancounter = count($asianCity);

    $europeanCity = array_filter(
        $handledInputData,
        'is_this_a_europe_city'
    );

    $europeancounter = count($europeanCity);

    $australianCity = array_filter(
        $handledInputData,
        'is_this_an_australian_city'
    );

    $australiancounter = count($australianCity);

    $africanCity = array_filter(
        $handledInputData,
        'is_this_an_african_city'
    );

    $africancounter = count($africanCity);

    $northAmericaCity = array_filter(
        $handledInputData,
        'is_this_a_north_american_city'
    );

    $northamericacounter = count($northAmericaCity);

    $southAmericaCity = array_filter(
        $handledInputData,
        'is_this_a_south_american_city'
    );

    $southamericacounter = count($southAmericaCity);

    $cnttext = "Азиатских городов - $asiancounter\nЕвропейских городов - $europeancounter\nАфриканских городов - $africancounter\nВ Северной Америке - $northamericacounter городов\nВ Южной Америке - $southamericacounter городов";

    
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
    foreach ($asianCity as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/european_city.csv", 'w');
    foreach ($europeanCity as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/australian_city.csv", 'w');
    foreach ($australianCity as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/african_city.csv", 'w');
    foreach ($africanCity as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/north_american_city.csv", 'w');
    foreach ($northAmericaCity as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/south_american_city.csv", 'w');
    foreach ($southAmericaCity as $entity) {
        fputcsv($outputFile, $entity);
    }

    $outputFile = fopen("$outputDirectoryName/counter.txt", 'w');
    fwrite($outputFile, $cnttext);
    fclose($outputFile);
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

function is_this_a_europe_city(array $entity): bool {
    $lat_east   = 67.45;
    $lng_east   = 66.13;
    $lat_north  = 71.08;
    $lng_north  = 27.39;
    $lat_west   = 38.46;
    $lng_west   = -9.29;
    $lat_south  = 36.00;
    $lng_south  = -5.36;

    $lat = (float)$entity[1];
    $lng = (float)$entity[2];

    if (($lat_north >= $lat) && ($lat >= $lat_south)) {
        if (($lng_east >= $lng) && ($lng >= $lng_west)) {
            return true;
        }
    }

    return false;
}

function is_this_an_african_city(array $entity): bool {
    $lat_east   = 10.25;
    $lng_east   = 51.21;
    $lat_north  = 77.43;
    $lng_north  = 104.18;
    $lat_west   = 39.29;
    $lng_west   = 26.10;
    $lat_south  = 1.16;
    $lng_south  = -103.3;

    $lat = (float)$entity[1];
    $lng = (float)$entity[2];

    if (($lat_north >= $lat) && ($lat >= $lat_south)) {
        if (($lng_east >= $lng) && ($lng >= $lng_west)) {
            return true;
        }
    }

    return false;
}

function is_this_a_north_american_city(array $entity): bool {
    $lat_east   = 52.24;
    $lng_east   = -55.40;
    $lat_north  = 71.50;
    $lng_north  = -94.45;
    $lat_west   = 65.35;
    $lng_west   = -168.00;
    $lat_south  = 7.13;
    $lng_south  = -80.52;

    $lat = (float)$entity[1];
    $lng = (float)$entity[2];

    if (($lat_north >= $lat) && ($lat >= $lat_south)) {
        if (($lng_east >= $lng) && ($lng >= $lng_west)) {
            return true;
        }
    }

    return false;
}

function is_this_a_south_american_city(array $entity): bool {
    $lat_east   = -7.09;
    $lng_east   = -34.47;
    $lat_north  = 12.00;
    $lng_north  = -72.00;
    $lat_west   = -4.40;
    $lng_west   = -81.20;
    $lat_south  = -53.54;
    $lng_south  = -71.18;

    $lat = (float)$entity[1];
    $lng = (float)$entity[2];

    if (($lat_north >= $lat) && ($lat >= $lat_south)) {
        if (($lng_east >= $lng) && ($lng >= $lng_west)) {
            return true;
        }
    }

    return false;
}

