<?php

use App\FileCsv;
use App\FileCsvReader;
use App\Filter;
use App\Handler\Counter;
use App\ParamResolver;
use App\FileHandler;
use App\FileXlsx;
use App\FIleXlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;

require 'vendor/autoload.php';
const DEFAULT_OUTPUT_FORMAT   = 'csv';
const DEFAULT_OUTPUT_DIR_NAME = 'output';

$params = $argv;
array_shift($params);
$paramResolver = new ParamResolver($params);
main($paramResolver);

function main(ParamResolver $paramResolver) {
    $entityList = [];
    $headers    = [];
    $counter    = new Counter();
    $counter->clearCounterFile();
    $fileXlsx = new FileXlsx($paramResolver->getOutputFileFormat());
    $fileCsv = new FileCsv($paramResolver->getOutputFileFormat());
    $fileXlsxReader = new FIleXlsxReader($paramResolver->getInputFileName());
    $fileCsvReader = new FileCsvReader($paramResolver->getInputFileName());

    if ($paramResolver->getInputFileFormat() === 'xlsx') {
        $entityList = $fileXlsxReader->handleInputFile()->getEntityList();
        $headers = $fileXlsxReader->getHeaders();
    } elseif ($paramResolver->getInputFileFormat() === 'csv') {
        $entityList = $fileCsvReader->handleInputFile()->getEntityList();
        $headers = $fileCsvReader->getHeaders();
    }

    $filter     = new Filter($entityList);

    $saintWordEntities        = $filter->getEntityContainsSaintWord($entityList);
    $sameCharacterCityCountry = $filter->getCityCountrySameCharacter($entityList);

    $asianCity        = $filter->getAsianCity();
    $europeanCity     = $filter->getEuCity();
    $africanCity      = $filter->getAfrCity();
    $northAmericaCity = $filter->getNaCity();
    $southAmericaCity = $filter->getSaCity();
    $australianCity   = $filter->getAuCity();

    $outputDirectoryName = $fileXlsx->prepareDir($paramResolver->getOutputDirectoryName());

    $counter->prepareCounterText($asianCity, 'Asian cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($europeanCity, 'European cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($africanCity, 'African cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($northAmericaCity, 'North American cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($southAmericaCity, 'South American cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($australianCity, 'Australian cities: %1')->writeDataToCounter($outputDirectoryName);

    if ($paramResolver->getOutputFileFormat() === 'csv') {
        $fileCsv->writeData($saintWordEntities, 'saint_word_entities', $headers);
        $fileCsv->writeData($sameCharacterCityCountry, 'same_character_city_country', $headers);
        $fileCsv->writeData($asianCity, 'asian_city', $headers);
        $fileCsv->writeData($europeanCity, 'european_city', $headers);
        $fileCsv->writeData($africanCity, 'african_city', $headers);
        $fileCsv->writeData($northAmericaCity, 'north_american_city', $headers);
        $fileCsv->writeData($southAmericaCity, 'south_american_city', $headers);
        $fileCsv->writeData($australianCity, 'australian_city', $headers);
    } elseif ($paramResolver->getOutputFileFormat() === 'xlsx') {
        $fileXlsx->writeData($saintWordEntities, 'saint_word_entities', $headers);
        $fileXlsx->writeData($sameCharacterCityCountry, 'same_character_city_country', $headers);
        $fileXlsx->writeData($asianCity, 'asian_city', $headers);
        $fileXlsx->writeData($europeanCity, 'european_city', $headers);
        $fileXlsx->writeData($africanCity, 'african_city', $headers);
        $fileXlsx->writeData($northAmericaCity, 'north_american_city', $headers);
        $fileXlsx->writeData($southAmericaCity, 'south_american_city', $headers);
        $fileXlsx->writeData($australianCity, 'australian_city', $headers);
    }
}
