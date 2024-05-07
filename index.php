<?php

include_once 'FileCsv.php';
include_once 'FileCsvReader.php';
include_once 'Filter.php';
include_once 'Counter.php';
const DEFAULT_OUTPUT_FORMAT   = 'csv';
const DEFAULT_OUTPUT_DIR_NAME = 'output';

$params = $argv;
array_shift($params);
main($params);

function main(array $params) {
    $inputFileName       = $params[0];
    $outputFileFormat    = $params[2] ?? DEFAULT_OUTPUT_FORMAT;
    $outputDirectoryName = $params[1] ?? DEFAULT_OUTPUT_DIR_NAME;

    $fileCsv       = new FileCsv();
    $fileCsvReader = new FileCsvReader($inputFileName);

    $headers    = $fileCsvReader->handleInputFile()->getHeaders();
    $entityList = $fileCsvReader->getEntityList();
    $filter     = new Filter($entityList);

    $saintWordEntities        = $filter->getEntityContainsSaintWord($entityList);
    $sameCharacterCityCountry = $filter->getCityCountrySameCharacter($entityList);

    $asianCity        = $filter->getAsianCity($entityList);
    $europeanCity     = $filter->getEuCity($entityList);
    $africanCity      = $filter->getAfrCity($entityList);
    $northAmericaCity = $filter->getNaCity($entityList);
    $southAmericaCity = $filter->getSaCity($entityList);
    $australianCity   = $filter->getAuCity($entityList);

    $counter    = new Counter(null);
    $counter->clearCounterFile($outputDirectoryName);

    $counter->handleCounter($asianCity, 'Asian cities')->writeDataToCounter($outputDirectoryName);
    $counter->handleCounter($europeanCity, 'European cities')->writeDataToCounter($outputDirectoryName);
    $counter->handleCounter($africanCity, 'African cities')->writeDataToCounter($outputDirectoryName);
    $counter->handleCounter($northAmericaCity, 'North American cities')->writeDataToCounter($outputDirectoryName);
    $counter->handleCounter($southAmericaCity, 'South American cities')->writeDataToCounter($outputDirectoryName);
    $counter->handleCounter($australianCity, 'Australian cities')->writeDataToCounter($outputDirectoryName);

    $fileCsv->prepareDir($outputDirectoryName);

    $fileCsv->writeData($saintWordEntities, 'saint_word_entities', $headers);
    $fileCsv->writeData($sameCharacterCityCountry, 'same_character_city_country', $headers);
    $fileCsv->writeData($asianCity, 'asian_city', $headers);
    $fileCsv->writeData($europeanCity, 'european_city', $headers);
    $fileCsv->writeData($africanCity, 'african_city', $headers);
    $fileCsv->writeData($northAmericaCity, 'north_american_city', $headers);
    $fileCsv->writeData($southAmericaCity, 'south_american_city', $headers);
    $fileCsv->writeData($australianCity, 'australian_city', $headers);

}
