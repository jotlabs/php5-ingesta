<?php
namespace Ingesta\Services\Facebook;

use Ingesta\Inputs\InputGetter;

class Facebook implements InputGetter
{
    protected $ogClient;

    public function __construct($ogClient)
    {
        $this->ogClient = $ogClient;
    }


    public function getInput($inputArgs)
    {

    }
}
