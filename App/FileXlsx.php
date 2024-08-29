<?php

namespace App;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
class FileXlsx extends FileHandler
{
    protected $outputFileFormat = '';

    public function __construct(?string $outputFileFormat = self::DEFAULT_OUTPUT_FORMAT)
    {
        $this->outputFileFormat = $outputFileFormat;
    }

    public function writeXlsxData(array $entityList, string $fileName, array $headers): self
    {
        $OutputFileName = $this->getFilePath($fileName, $this->outputFileFormat);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(array_merge([$headers], $entityList), null, 'A1');

        $writer = new XlsxWriter($spreadsheet);
        $writer->save($OutputFileName);

        return $this;
    }

}