<?php
namespace Ingesta\Processors;

class InputProcessor implements Processor
{
    protected $pipeline;

    public function __construct()
    {
        $this->pipeline = array();
    }


    public function addFilter($filter)
    {
        $this->pipeline[] = $filter;
    }


    public function addFormatter($formatter)
    {
        $this->pipeline[] = $formatter;
    }


    public function process($input)
    {
        $processed = null;

        if (is_array($input)) {
            $processed = $this->processList($input);
        } else {
            $processed = $this->processItem($input);
        }

        return $processed;
    }


    protected function processList($itemList)
    {
        $processed = array();

        foreach ($itemList as $item) {
            $response = $this->processItem($item);
            if ($response) {
                $processed[] = is_bool($response) ? $item : $response;
            }
        }

        return $processed;
    }


    protected function processItem($item)
    {
        echo "[-INFO-] Processing: {$item->getTitle()}\n";

        foreach ($this->pipeline as $step) {
            $response = $step->process($item);

            if ($response === false) {
                echo "[-INFO-] Filtered out: {$item->getTitle()}\n";
                $item = false;
                break;
            } elseif ($response !== true) {
                $item = $response;
            }
        }
        return $item;
    }
}
