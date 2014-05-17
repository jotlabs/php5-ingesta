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


    public function addNextPage($document)
    {
        if ($document->meta->code === 200) {
            $this->document->pagination = $document->pagination;
            $this->document->data = array_merge($this->document->data, $document->data);
        } else {
            $this->document->pagination->next_url = false;
            $this->document->pagination->next_max_tag_id = false;
        }
    }


    public function getNextPage()
    {
        $nextUrl = false;
        if (!empty($this->document->pagination->next_url)) {
            $nextUrl = $this->document->pagination->next_url;
        }

        return $nextUrl;
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
