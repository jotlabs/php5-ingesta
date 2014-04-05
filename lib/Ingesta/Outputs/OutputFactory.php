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


    public function getWriter($config)
    {

        $writer = null;

        switch ($config->type) {
            case 'JsonFileWriter':
                $writer = $this->getJsonFileWriter($config);
                break;
        }

        return $writer;
    }


    protected function getJsonFileWriter($config)
    {
        $filePath = $config->file;
        $writer = new JsonFileWriter($filePath);
        return $writer;
    }
}
