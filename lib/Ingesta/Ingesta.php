<?php
namespace Ingesta;

class Ingesta
{
    const VERSION = '0.0.1';


    public static function run()
    {
        $self = new Ingesta();
        $cmdArgs = $self->getCmdArgs();
        $self->execute($cmdArgs);
    }


    public function execute($args)
    {
        echo 'Ingesta ', self::VERSION, ": Running...\n";
        print_r($args);
    }


    protected function getCmdArgs()
    {
        $args = getopt(
            '',
            array(
                'help'
            )
        );

        return $args;
    }
}
