<?php
namespace Ingesta\Services\Wordpress\Wrappers;


class Post
{
    protected $post;


    public function __construct($post)
    {
        $this->post = (object) $post;
    }
}
