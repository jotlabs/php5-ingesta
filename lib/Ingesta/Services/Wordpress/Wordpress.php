<?php
namespace Ingesta\Services\Wordpress;

use Ingesta\Services\Wordpress\Wrappers\Posts;

class Wordpress
{
    const METHOD_SAY_HELLO = 'demo.sayHello';
    const METHOD_GET_POSTS = 'wp.getPosts';

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
}
