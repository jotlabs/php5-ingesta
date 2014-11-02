<?php
namespace Ingesta\Services\Wordpress;

use Ingesta\Inputs\InputGetter;
use Ingesta\Services\Wordpress\Wrappers\Post;
use Ingesta\Services\Wordpress\Wrappers\User;

class Wordpress implements InputGetter
{
    const METHOD_SAY_HELLO = 'demo.sayHello';
    const METHOD_GET_POSTS = 'wp.getPosts';
    const METHOD_GET_POST  = 'wp.getPost';
    const METHOD_GET_USERS = 'wp.getUsers';

    protected $client;
    protected $credentials;
    protected $authors;


    public function __construct($client)
    {
        $this->client = $client;
        $this->authors = array();
    }


    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
    }


    public function getInput($inputArgs)
    {
        $input  = null;
        $method = $inputArgs->method;
        $args   = !empty($inputArgs->args) ? (array)$inputArgs->args : array();

        switch ($method) {
            case self::METHOD_GET_POSTS:
                $input = $this->getPosts($args);
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


    public function getPosts($args = null)
    {
        $posts = null;

        if ($this->credentials) {
            $response = $this->client->callMethod(
                self::METHOD_GET_POSTS,
                array(
                    1,
                    $this->credentials->getUsername(),
                    $this->credentials->getPassword(),
                    $args
                )
            );

            if (is_array($response) && count($response)) {
                $posts = array();

                foreach ($response as $postData) {
                    $postData['author'] = $this->getUser($postData['post_author']);
                    $post = new Post($postData);
                    $posts[] = $post;
                }
            }

        } else {
            throw new AuthenticationRequiredException("Wordpress endpoint 'wp.getPosts' requires authentication.");

        }
        return $posts;
    }


    public function getUser($userId)
    {
        if (empty($this->users)) {
            $users = $this->getUsers();
            foreach ($users as $user) {
                $this->users[$user->getId()] = $user;
            }
        }

        return $this->users[$userId];
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


    public function getUsers()
    {
        $users = null;

        if ($this->credentials) {
            $response = $this->client->callMethod(
                self::METHOD_GET_USERS,
                array(
                    1,
                    $this->credentials->getUsername(),
                    $this->credentials->getPassword()
                )
            );

            if (is_array($response) && count($response)) {
                $users = array();

                foreach ($response as $userData) {
                    $user = new User($userData);
                    $users[] = $user;
                }
            }

        } else {
            throw new AuthenticationRequiredException("Wordpress endpoint 'wp.getUsers' requires authentication.");

        }
        return $users;
    }
}
