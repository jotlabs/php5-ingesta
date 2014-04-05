<?php
namespace Ingesta\Services\Wordpress\Wrappers;

class Term
{
    protected $term;

    public function __construct($term)
    {
        $this->term = (object) $term;
    }


    public function getTermId()
    {
        return $this->term->term_id;
    }


    public function getName()
    {
        return $this->term->name;
    }


    public function getSlug()
    {
        return $this->term->slug;
    }


    public function getDescription()
    {
        return $this->term->description;
    }


    public function getTaxonomy()
    {
        return $this->term->taxonomy;
    }


    public function getTotal()
    {
        return $this->term->count;
    }
}
