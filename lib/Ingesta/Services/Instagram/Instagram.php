<?php
namespace Ingesta\Services\Instagram;

use Ingesta\Inputs\InputGetter;
use Ingesta\Services\Instagram\Wrappers\PaginatedResults;

class Instagram implements InputGetter
{
    const MEDIA_BY_ID_ENDPOINT = 'https://api.instagram.com/v1/media/{mediaId}?client_id={clientId}';
    const MEDIA_BY_SHORTCODE_ENDPOINT = 'https://api.instagram.com/v1/media/shortcode/{shortcode}?client_id={clientId}';
    const RECENT_TAG_ENDPOINT = 'https://api.instagram.com/v1/tags/{tag}/media/recent?client_id={clientId}';

    const METHOD_GET_MEDIA_BY_SHORTCODE = 'getMediaByShortcode';
    const METHOD_GET_RECENT_TAGS = 'getTagRecent';

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


    public function getMediaByWebUrl($mediaUrl)
    {
        $shortcode = $this->getMediaShortcodeFromUrl($mediaUrl);
        $media = $this->getMediaByShortcode($shortcode);
        return $media;
    }


    public function getInput($inputArgs)
    {
        $input  = null;
        $method = $inputArgs->method;

        switch ($method) {
            case self::METHOD_GET_RECENT_TAGS:
                $input = $this->getRecentByTag($inputArgs->tag);
                break;
        }

        return $input;
    }


    public function getMediaByShortcode($shortcode)
    {
        $url = $this->expandUrlTemplate(
            self::MEDIA_BY_SHORTCODE_ENDPOINT,
            array(
                'shortcode' => $shortcode,
                'clientId'  => $this->apiClientId
            )
        );

        echo "[-INFO-] Instagram getMediaByShortcode {$shortcode}: {$url}\n";
        $response = $this->getJson($url);

        return $response->data;
    }


    public function getRecentByTag($tag, $followNextPage = true, $maxPages = 200)
    {
        $pageCount = 1;
        $url = $this->expandUrlTemplate(
            self::RECENT_TAG_ENDPOINT,
            array(
                'tag'      => $tag,
                'clientId' => $this->apiClientId
            )
        );

        echo "[-INFO-] Instagram getRecentByTag {$tag}/{$pageCount}: {$url}\n";
        $response = $this->getJson($url);
        $results  = new PaginatedResults($response);

        $nextPage = $results->getNextPage();
        while ($nextPage && $followNextPage) {
            $pageCount++;
            echo "[-INFO-] Instagram getRecentByTag {$tag}/{$pageCount}: {$nextPage}\n";
            $response = $this->getJson($nextPage);

            $nextPage = null;

            if ($response) {
                $results->addNextPage($response);

                if ($pageCount <= $maxPages) {
                    $nextPage = $results->getNextPage();
                }
            }
        }

        return $results;
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


    public function getMediaShortcodeFromUrl($mediaUrl)
    {
        /*
            URL Patterns:
            shortlink: http://instagram.com/p/tQt9joJaX0/?modal=true
        */

        $shortcode = '';
        $url = parse_url($mediaUrl);

        if ($url['host'] === 'instagram.com') {
            $pathString = trim($url['path'], '/');
            $path = explode('/', $pathString);
            $shortcode = $path[1];
        }

        return $shortcode;
    }
}
