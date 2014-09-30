<?php
namespace Ingesta\Services;

use Ingesta\Inputs\InputGetter;

abstract class ServiceBase implements InputGetter
{
    # Response codes
    const RESPONSE_OK = 200;

    protected $httpClient;
    protected $urlTemplate;

    abstract public function getInput($inputArgs);


    public function __construct($httpClient, $urlTemplate = null)
    {
        $this->httpClient  = $httpClient;

        if ($urlTemplate) {
            $this->urlTemplate = $urlTemplate;
        }
    }



    protected function getJson($url)
    {
        $response = $this->httpClient->get($url);
        $json     = json_decode($response);
        return $json;
    }


    protected function getHTML($url)
    {
        $response = $this->httpClient->get($url);
        $html     = $response;
        return $html;
    }


    protected function postWithJsonResponse($url, $params)
    {
        $response = $this->httpClient->post($url, $params);
        $json     = json_decode($response);
        return $json;
    }

    protected function expandUrlTemplate($urlTemplate, $data)
    {
        return $this->urlTemplate->renderTemplate($urlTemplate, $data);
    }
}
