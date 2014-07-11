<?php
namespace Ingesta\Processors\Filters;

class DraftFilter
{

    public function process($item)
    {
        return $this->isPublished($item);
    }


    public function isPublished($item)
    {
        //echo "[-INFO-] Publish state: {$item->getStatus()}\n";
        return $item->isPublished();
    }
}
