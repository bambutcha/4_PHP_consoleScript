<?php

namespace App;

class ParamResolver
{
    const INPUT_FILE_NAME_PARAM_KEY         = 0;
    const OUTPUT_FILE_FORMAT_PARAM_KEY      = 1;
    const OUTPUT_DIRECTORY_NAME_PARAM_VALUE = 2;

    protected $inputFileName;
    protected $outputFileFormat;
    protected $outputDirectoryName;
    protected $inputFileFormat;

    public function __construct(array $params)
    {
        $this->inputFileName       = $params[self::INPUT_FILE_NAME_PARAM_KEY];
        $this->outputFileFormat    = $params[self::OUTPUT_FILE_FORMAT_PARAM_KEY] ?? null;
        $this->outputDirectoryName = $params[self::OUTPUT_DIRECTORY_NAME_PARAM_VALUE] ?? null;
    }

    public function getInputFileName(): string
    {
        return $this->inputFileName;
    }

    public function getOutputFileFormat(): string
    {
        return $this->outputFileFormat ?? 'csv';
    }

    public function getOutputDirectoryName(): string
    {
        return $this->outputDirectoryName ?? FileCsv::DEFAULT_OUTPUT_DIR_NAME;
    }

    public function getInputFileFormat(): string
    {
        $formats = explode('.', $this->inputFileName);
        $this->inputFileFormat = end($formats);

        return $this->inputFileFormat;
    }

}