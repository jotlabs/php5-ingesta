<?php
namespace Ingesta\Services\Wordpress\Wrappers;

class Term
{
    protected $term;

    public function __construct($term)
    {
        $this->term = $term;
    }
}
