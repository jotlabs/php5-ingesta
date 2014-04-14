<?php
namespace Ingesta\Clients\Http;

use Ingesta\Clients\Http;

class MockHttp implements Http
{
    protected $responses = array();


    public function get($url)
    {
        $response = '';

        if (array_key_exists($url, $this->responses)) {
            $response = $this->responses[$url];
        }

        return $response;
    }


    public function addUrlResponse($url, $response)
    {
        $this->responses[$url] = $response;
    }
}
