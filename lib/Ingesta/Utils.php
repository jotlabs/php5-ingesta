<?php
namespace Ingesta;

class Utils
{
    private static $libDir;

    /******************************************************************
    * PSR-0 Autoloader
    *
    * Do not use if you are using Composer to autoload dependencies.
    ******************************************************************/
    public static function autoload($className)
    {
        $fileName  = self::$libDir;
        $fileName .= self::classNameToFilePath($className);

        if (file_exists($fileName)) {
            require $fileName;
        }
    }


    public static function registerAutoloader()
    {
        $classFile = str_replace('\\', '/', __CLASS__ . '.php');
        self::$__libDir = str_replace($classFile, '', __FILE__);
        spl_autoload_register(__NAMESPACE__ . "\\Utils::autoload");
    }


    protected static function classNameToFilePath($className)
    {
        $className = ltrim($className, '\\');
        $lastNsPos = strripos($className, '\\');
        $filePath  = '';

        if ($lastNsPos) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $filePath  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                            . DIRECTORY_SEPARATOR;
        }

        $filePath .= str_replace('_', DIRECTORY_SEPARATOR, $className)
            . '.php';

        return $filePath;
    }
}
