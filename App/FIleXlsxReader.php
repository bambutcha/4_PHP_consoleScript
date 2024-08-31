<?php
namespace App;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class FIleXlsxReader extends FileXlsx
{
    protected $inputFileName;
    #protected $outputFileName;
    protected $headers;
    protected $entityList;

    public function __construct(string $inputFileName)
    {
        $this->inputFileName = $inputFileName;
    }

    public function handleInputFile(): self
    {
        $reader      = new XlsxReader();
        $reader->setReadDataOnly(true);

        try{
            $spreadsheet = $reader->load($this->inputFileName);

            $sheets = $spreadsheet->getAllSheets();

            $this->entityList = current($sheets)->toArray();
            $this->headers    = current($this->entityList);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Error reading XLSX file: ' . $exception->getMessage());
        } finally {
            unset($reader);
        }

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