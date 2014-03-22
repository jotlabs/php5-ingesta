<?php
namespace Ingesta;

use PHPUnit_Framework_TestCase;

class IngestaTest extends PHPUnit_Framework_TestCase
{

    public function testHasVersion()
    {
        $this->assertTrue(is_string(Ingesta::VERSION));
    }
}
