<?php
namespace Ingesta\Services\Instagram;

use Ingesta\Services\Instagram\Wrappers\PaginatedResults;

class Instagram
{
    const RECENT_TAG_ENDPOINT = 'https://api.instagram.com/v1/tags/{tag}/media/recent?client_id={clientId}';

    protected $httpClient;
    protected $urlTemplate;

    protected $apiClientId;


    public function __construct($httpClient, $urlTemplate)
    {
        $this->httpClient = $httpClient;
    }


    public function setApiClientId($apiClientId)
    {
        $this->apiClientId = $apiClientId;
    }


    public function getRecentByTag($tag)
    {
        $url = $this->expandUrlTemplate(
            self::RECENT_TAG_ENDPOINT,
            array(
                'tag'      => $tag,
                'clientId' => $this->apiClientId
            )
        );
        //echo "Requesting: {$url}\n";
        $response = $this->getJson($url);
        return new PaginatedResults($response);
    }


    public function getJson($url)
    {
        $response = $this->httpClient->get($url);
        $json     = json_decode($response);
        return $json;
    }


    public function expandUrlTemplate($urlTemplate, $data)
    {
        if (empty($this->urlTemplate)) {
            $this->urlTemplate = new \Ingesta\Utils\UrlTemplate();
        }

        return $this->urlTemplate->renderTemplate($urlTemplate, $data);
    }
}
