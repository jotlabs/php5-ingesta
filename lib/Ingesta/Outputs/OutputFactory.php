<?php
namespace Ingesta\Outputs;

use Ingesta\Outputs\Writers\JsonFileWriter;

class OutputFactory
{
    protected static $INSTANCE;


    protected function __construct()
    {

    }


    public static function getInstance()
    {
        if (!self::$INSTANCE) {
            self::$INSTANCE = new OutputFactory();
        }

        return self::$INSTANCE;
    }


    public function getOutput($config)
    {

        $output = null;

        //print_r($config);
        switch ($config->format) {
            case 'JsonFileWriter':
                $output = $this->getJsonFileWriter($config);
                break;
        }

        return $output;
    }


    protected function getJsonFileWriter($config)
    {
        $filePath = $config->file;
        $output = new JsonFileWriter($filePath);
        return $output;
    }
}
