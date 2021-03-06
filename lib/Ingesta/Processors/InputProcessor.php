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

        if (is_array($input) || is_a($input, 'Traversable')) {
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
        $titleStr = substr($item->getTitle(), 0, 64);
        echo "[-INFO-] Processing: {$titleStr}\n";

        foreach ($this->pipeline as $step) {
            $response = $step->process($item);

            if ($response === false) {
                echo "[-INFO-] Filtered out: {$titleStr}\n";
                $item = false;
                break;
            } elseif ($response !== true) {
                $item = $response;
            }
        }
        return $item;
    }
}
