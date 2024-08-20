<?php

use App\FileCsv;
use App\FileCsvReader;
use App\Filter;
use App\Handler\Counter;
use App\ParamResolver;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use \PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;

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

    if ($paramResolver->getInputFileFormat() === 'xlsx') {
        $reader      = new XlsxReader();
        $spreadsheet = $reader->load($paramResolver->getInputFileName());

        $sheets = $spreadsheet->getAllSheets();

        $headers    = current($entityList);
        $entityList = current($sheets)->toArray();

        $writer = new XlsxWriter($spreadsheet);
        $writer->save('is_entity_contains_saint_word.xlsx');
    } elseif ($paramResolver->getInputFileFormat() === 'csv') {
        $fileCsvReader = new FileCsvReader($paramResolver->getInputFileName());

        $headers    = $fileCsvReader->getHeaders();
        $entityList = $fileCsvReader->handleInputFile()->getEntityList();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);
        $spreadsheet->createSheet()->fromArray($entityList);


        $writer = new XlsxWriter($spreadsheet);
        $writer->save('is_entity_contains_saint_word_2.xlsx');
    }

    $filter     = new Filter($entityList);

    $saintWordEntities        = $filter->getEntityContainsSaintWord($entityList);
    $sameCharacterCityCountry = $filter->getCityCountrySameCharacter($entityList);

    $asianCity        = $filter->getAsianCity($entityList);
    $europeanCity     = $filter->getEuCity($entityList);
    $africanCity      = $filter->getAfrCity($entityList);
    $northAmericaCity = $filter->getNaCity($entityList);
    $southAmericaCity = $filter->getSaCity($entityList);
    $australianCity   = $filter->getAuCity($entityList);

    $fileCsv = new FileCsv();

    $outputDirectoryName = $fileCsv->prepareDir($paramResolver->getOutputDirectoryName());

    $counter->prepareCounterText($asianCity, 'Asian cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($europeanCity, 'European cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($africanCity, 'African cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($northAmericaCity, 'North American cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($southAmericaCity, 'South American cities: %1')->writeDataToCounter($outputDirectoryName);
    $counter->prepareCounterText($australianCity, 'Australian cities: %1')->writeDataToCounter($outputDirectoryName);

    $fileCsv->writeData($saintWordEntities, 'saint_word_entities', $headers);
    $fileCsv->writeData($sameCharacterCityCountry, 'same_character_city_country', $headers);
    $fileCsv->writeData($asianCity, 'asian_city', $headers);
    $fileCsv->writeData($europeanCity, 'european_city', $headers);
    $fileCsv->writeData($africanCity, 'african_city', $headers);
    $fileCsv->writeData($northAmericaCity, 'north_american_city', $headers);
    $fileCsv->writeData($southAmericaCity, 'south_american_city', $headers);
    $fileCsv->writeData($australianCity, 'australian_city', $headers);

}
