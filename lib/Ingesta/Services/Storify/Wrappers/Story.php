<?php
namespace Ingesta\Services\Storify\Wrappers;

class Story
{
    protected $story;


    public function __construct($post)
    {
        $this->post = (object) $post;
    }



}
