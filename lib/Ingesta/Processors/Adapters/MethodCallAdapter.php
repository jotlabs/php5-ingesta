<?php
namespace Ingesta\Processors\Adapters;

use Ingesta\Processors\Processor;

class MethodCallAdapter implements Processor
{
    protected $methodCall;
    protected $methodArgs;


    public function __construct($methodCallArray, $methodArgs = array())
    {
        $this->methodCall = $methodCallArray;
        $this->methodArgs = $methodArgs;
    }


    public function process($input)
    {
        $args = array_merge(array($input), $this->methodArgs);

        $output = call_user_func_array($this->methodCall, $args);
        return $output;
    }
}
