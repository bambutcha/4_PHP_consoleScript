<?php

$params = $argv;
array_shift($params);
main($params);

function main(array $params) {
    $inputFileName       = $params[0];
    $outputDirectoryName = $params[1] ?? 'output';

    $inputFileData = file($inputFileName);
    $headers       = array_shift($inputFileData); // Removed the top bottom one and put it in a variable

    $header_array = explode(',', $headers);
    $header_array = array_map(function($entity){
        return trim($entity, '"');
    }, $header_array);
    $header_array = array_map(function($entity){
        return trim($entity, "\"\n");
    }, $header_array);

    $handledInputData = [];
    foreach ($inputFileData as $inputEntity) {
        $tmp = explode(',', $inputEntity); // Remove commas from the data

        $handledInputData[] = array_map('prepare_entity_column', $tmp); // We apply the function
                                                                                // which removes all quotes
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

    $asianCounter = count($asianCity);

    $europeanCity = array_filter(
        $handledInputData,
        'is_this_a_europe_city'
    );

    $europeanCounter = count($europeanCity);

    $australianCity = array_filter(
        $handledInputData,
        'is_this_an_australian_city'
    );

    $australianСounter = count($australianCity);

    $africanCity = array_filter(
        $handledInputData,
        'is_this_an_african_city'
    );

    $africanСounter = count($africanCity);

    $northAmericaCity = array_filter(
        $handledInputData,
        'is_this_a_north_american_city'
    );

    $northАmericaСounter = count($northAmericaCity);

    $southAmericaCity = array_filter(
        $handledInputData,
        'is_this_a_south_american_city'
    );

    $southАmericaСounter = count($southAmericaCity);

    $counterText = implode(PHP_EOL, [
        "В Азии - " . $asianCounter . " городов",
        "В Европе - " . $europeanCounter . " городов",
        "В Африке - " . $africanСounter . " городов",
        "В Северной Америке - " . $northАmericaСounter . " городов",
        "В Южной Америке - " . $southАmericaСounter . " городов",
        "В Австралии - " . $australianСounter . " городов"
    ]);

    mkdir($outputDirectoryName);

    /*/ $outputFile = fopen("$outputDirectoryName/saint_word_entities.csv", 'w');
    foreach ($saintWordEntities as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($saintWordEntities, $outputDirectoryName, "saint_word_entities.csv", $header_array);

    /*/ $outputFile = fopen("$outputDirectoryName/same_character_city_country.csv", 'w');
    foreach ($sameCharacterCityCountry as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($sameCharacterCityCountry, $outputDirectoryName, "same_character_city_country.csv", $header_array);

    /*/ $outputFile = fopen("$outputDirectoryName/asian_city.csv", 'w');
    foreach ($asianCity as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($asianCity, $outputDirectoryName, "asian_city.csv", $header_array);

    /*/ $outputFile = fopen("$outputDirectoryName/european_city.csv", 'w');
    foreach ($europeanCity as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($europeanCity, $outputDirectoryName, "european_city.csv", $header_array);

    /*/ $outputFile = fopen("$outputDirectoryName/australian_city.csv", 'w');
    foreach ($australianCity as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($australianCity, $outputDirectoryName, "australian_city.csv", $header_array);

    /*/ $outputFile = fopen("$outputDirectoryName/african_city.csv", 'w');
    foreach ($africanCity as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($africanCity, $outputDirectoryName, "african_city.csv", $header_array);

    /*/ $outputFile = fopen("$outputDirectoryName/north_american_city.csv", 'w');
    foreach ($northAmericaCity as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($northAmericaCity, $outputDirectoryName, "north_american_city.csv", $header_array);

    /*/ $outputFile = fopen("$outputDirectoryName/south_american_city.csv", 'w');
    foreach ($southAmericaCity as $entity) {
        fputcsv($outputFile, $entity);
    } /*/

    fopen_write_with_header($southAmericaCity, $outputDirectoryName, "south_american_city.csv", $header_array);

    fopen_write_with_header($australianCity, $outputDirectoryName, "australian_city.csv", $header_array);

    $outputFile = fopen("$outputDirectoryName/counter.txt", 'w');
    fwrite($outputFile, $counterText);
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
    $lat_east =  66.05;
    $lng_east =  169.4;
    $lat_north = 77.43;
    $lng_north = 104.18;
    $lat_west =  39.29;
    $lng_west =  26.04;
    $lat_south = 1.16;
    $lng_south = 103.30;

    $lat = (float) $entity[1];
    $lng = (float) $entity[2];

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

function is_this_an_australian_city(array $entity): bool {
    $lat_east   = -28.38;
    $lng_east   = 153.38;
    $lat_north  = -10.41;
    $lng_north  = 142.31;
    $lat_west   = -26.09;
    $lng_west   = 113.09;
    $lat_south  = -39.08;
    $lng_south  = 146.22;

    $lat = (float)$entity[1];
    $lng = (float)$entity[2];

    if (($lat_north >= $lat) && ($lat >= $lat_south)) {
        if (($lng_east >= $lng) && ($lng >= $lng_west)) {
            return true;
        }
    }

    return false;
}

function fopen_write_with_header(array $entityBody, string $stream, string $fileName, array $header): void {
    $outputFile = fopen("$stream/$fileName", 'w');
    if (!$outputFile) {
        throw new Exception('Ошибка открытия файла');
    }

        fputcsv($outputFile, $header);

    foreach ($entityBody as $entity) {
        fputcsv($outputFile, $entity);
    }
    fclose($outputFile);
}


