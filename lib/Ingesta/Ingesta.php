<?php
namespace Ingesta;

class Ingesta
{
    const VERSION = '0.0.1';

    protected static $shortCmdOptions = '';
    protected static $longCmdOptions  = array(
        'help'
    );


    public static function run()
    {
        echo 'Ingesta v', self::VERSION, "\n";
        $self = new Ingesta();
        $cmdArgs = $self->getCmdArgs();
        $self->execute($cmdArgs);
    }


    public function execute($args)
    {
        print_r($args);
    }


    protected function getCmdArgs()
    {
        $args = getopt(
            self::$shortCmdOptions,
            self::$longCmdOptions
        );

        return $args;
    }
}
