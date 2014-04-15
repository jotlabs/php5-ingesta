<?php
namespace Ingesta\Services\Instagram\Wrappers;

use IteratorAggregate;
use ArrayIterator;

class PaginatedResults implements IteratorAggregate
{
    const RESPONSE_OK = '200';

    protected $document;


    public function __construct($document)
    {
        $this->document = $document;
    }


    public function getNextUrl()
    {
        return $this->document->pagination->next_url;
    }


    public function getResponseCode()
    {
        return $this->document->meta->code;
    }


    public function getIterator()
    {
        $results = $this->wrapResults($this->document->data);
        return new ArrayIterator($results);
    }



    protected function wrapResults($results)
    {
        $wrapped = array_map(
            function ($mediaResult) {
                return new MediaResult($mediaResult);
            },
            $results
        );
        return $wrapped;
    }
}
