<?php
namespace App;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class FIleXlsxReader extends FileXlsx
{
    protected $inputFileName;
    protected $headers;
    protected $entityList;

    public function __construct(string $inputFileName)
    {
        $this->inputFileName = $inputFileName;
    }

    public function handleInputFile(): self
    {
        $reader      = new XlsxReader();
        $spreadsheet = $reader->load($this->inputFileName);

        $sheets = $spreadsheet->getAllSheets();

        $this->entityList = current($sheets)->toArray();
        $this->headers    = current($this->entityList);

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers ?? [];
    }

    public function getEntityList(): array
    {
        return $this->entityList ?? [];
    }
}