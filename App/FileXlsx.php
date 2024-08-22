<?php

namespace App;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
class FileXlsx extends FileHandler
{

    public function writeXlsxData(array $entityList, string $fileName, array $headers): self
    {
        $filePath = $this->getFilePath($fileName);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);
        $spreadsheet->createSheet()->fromArray($entityList);

        $writer = new XlsxWriter($spreadsheet);
        $writer->save($filePath);

        return $this;
    }
}