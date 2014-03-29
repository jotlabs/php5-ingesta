<?php
namespace Ingesta\Services\Wordpress;

use Ingesta\Services\InputGetter;
use Ingesta\Services\Wordpress\Wrappers\Posts;
use Ingesta\Services\Wordpress\Wrappers\Post;

class Wordpress implements InputGetter
{
    const METHOD_SAY_HELLO = 'demo.sayHello';
    const METHOD_GET_POSTS = 'wp.getPosts';
    const METHOD_GET_POST  = 'wp.getPost';

    protected $client;
    protected $credentials;


    public function __construct($client)
    {
        $this->client = $client;
    }


    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
    }


    public function getInput($inputArgs)
    {
        $input  = null;
        $method = $inputArgs->method;

        switch ($method) {
            case self::METHOD_GET_POSTS:
                $input = $this->getPosts();
                break;
        }

        return $input;
    }


    public function sayHello()
    {
        $response = $this->client->callMethod(
            self::METHOD_SAY_HELLO
        );
        return $response;
    }


    public function getPosts()
    {
        $posts = null;

        if ($this->credentials) {
            $response = $this->client->callMethod(
                self::METHOD_GET_POSTS,
                array(
                    1,
                    $this->credentials->getUsername(),
                    $this->credentials->getPassword()
                )
            );

            $posts = new Posts($response);

        } else {
            throw new AuthenticationRequiredException("Wordpress endpoint 'wp.getPosts' requires authentication.");

        }
        return $posts;
    }


    public function getPost($postId)
    {
        $posts = null;

        if ($this->credentials) {
            $response = $this->client->callMethod(
                self::METHOD_GET_POST,
                array(
                    1,
                    $this->credentials->getUsername(),
                    $this->credentials->getPassword(),
                    $postId
                )
            );

            $post = new Post($response);

        } else {
            throw new AuthenticationRequiredException("Wordpress endpoint 'wp.getPosts' requires authentication.");

        }
        return $post;
    }
}
