<?php
namespace Ingesta\Outputs\Writers;

use Ingesta\Outputs\OutputWriter;

class JsonFileWriter implements OutputWriter
{
    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }


    public function write($output)
    {
        $json = json_encode($output);
        print_r($json);
        $response = file_put_contents($this->filePath, $json);

        return $response;
    }
}
