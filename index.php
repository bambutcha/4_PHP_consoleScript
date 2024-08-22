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
    $fileHandler = new FileHandler($paramResolver->getOutputFileFormat());
    $fileXlsx = new FileXlsx();
    $fileCsv = new FileCsv();
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

    $outputDirectoryName = $fileHandler->prepareDir($paramResolver->getOutputDirectoryName());

    $counter->prepareCounterText($asianCity, 'Asian cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($europeanCity, 'European cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($africanCity, 'African cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($northAmericaCity, 'North American cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($southAmericaCity, 'South American cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($australianCity, 'Australian cities: %1')->writeDataToCounter($outputDirectoryName);

    if ($paramResolver->getInputFileFormat() === 'csv') {
        $fileCsv->writeCsvData($saintWordEntities, 'saint_word_entities', $headers);
        $fileCsv->writeCsvData($sameCharacterCityCountry, 'same_character_city_country', $headers);
        $fileCsv->writeCsvData($asianCity, 'asian_city', $headers);
        $fileCsv->writeCsvData($europeanCity, 'european_city', $headers);
        $fileCsv->writeCsvData($africanCity, 'african_city', $headers);
        $fileCsv->writeCsvData($northAmericaCity, 'north_american_city', $headers);
        $fileCsv->writeCsvData($southAmericaCity, 'south_american_city', $headers);
        $fileCsv->writeCsvData($australianCity, 'australian_city', $headers);
    } elseif ($paramResolver->getInputFileFormat() === 'xlsx') {
        $fileXlsx->writeXlsxData($saintWordEntities, 'saint_word_entities', $headers);
        $fileXlsx->writeXlsxData($sameCharacterCityCountry, 'same_character_city_country', $headers);
        $fileXlsx->writeXlsxData($asianCity, 'asian_city', $headers);
        $fileXlsx->writeXlsxData($europeanCity, 'european_city', $headers);
        $fileXlsx->writeXlsxData($africanCity, 'african_city', $headers);
        $fileXlsx->writeXlsxData($northAmericaCity, 'north_american_city', $headers);
        $fileXlsx->writeXlsxData($southAmericaCity, 'south_american_city', $headers);
        $fileXlsx->writeXlsxData($australianCity, 'australian_city', $headers);
    }


}
