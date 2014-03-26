<?php
namespace Ingesta\Services\Wordpress\Wrappers;


class Posts
{
    protected $posts;


    public function __construct($posts)
    {
        $this->posts = $posts;
    }


    public function getNumberOfPosts()
    {
        return sizeof($this->posts);
    }


    public function getPost($position)
    {
        $post = false;

        if ($this->isValidPostNumber($position)) {
            $post = new Post($this->posts[$position]);
        }

        return $post;
    }


    protected function isValidPostNumber($postNo)
    {
        $isValid = false;

        if ($postNo >= 0 && $postNo < $this->getNumberOfPosts()) {
            $isValid = true;
        }

        return $isValid;
    }
}
