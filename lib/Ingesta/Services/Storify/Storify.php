<?php
namespace Ingesta\Services\Storify;

use Ingesta\Services\ServiceBase;
use Ingesta\Services\Storify\Wrappers\Story;

class Storify extends ServiceBase
{
    # GET USER STORIES
    const METHOD_GET_USER_STORIES = 'getUserStories';

    # Base API URL:
    const API_BASE_URL = 'http://api.storify.com/v1';

    # URL Templates
    const URL_USER_AUTH_ENDPOINT    = 'https://api.storify.com/v1/auth';
    const URL_USER_STORIES_ENDPOINT = 'http://api.storify.com/v1/stories/{username}';
    const URL_USER_STORY_ENDPOINT   = 'http://api.storify.com/v1/stories/{username}/{slug}';

    # URL Templates -- HTML
    const URL_USER_STORY_EMBED      = 'http://storify.com/{username}/{slug}/embed';

    private $apiKey = null;


    public function __construct($httpClient, $urlTemplate)
    {
        parent::__construct($httpClient, $urlTemplate);
    }


    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }


    public function getInput($inputArgs)
    {
        $input  = null;
        $method = $inputArgs->method;

        switch ($method) {
            case self::METHOD_GET_USER_STORIES:
                $input = $this->getUserStories($inputArgs->username);
                break;
        }

        return $input;
    }


    public function authenticateUser($username, $password)
    {
        $user = null;

        $apiUrl = self::URL_USER_AUTH_ENDPOINT;
        $params = array(
            'username' => $username,
            'password' => $password,
            'api_key'  => $this->apiKey
        );

        $response = $this->postWithJsonResponse($apiUrl, $params);
        //print_r($response);

        if (!empty($response->code) && $response->code === self::RESPONSE_OK) {
            $user = $response->content;
        }

        return $user->_token;
    }


    public function getUserStories($username, $userToken = null)
    {
        $stories = array();
        $apiUrl = $this->expandUrlTemplate(
            self::URL_USER_STORIES_ENDPOINT,
            array('username' => $username)
        );

        # Quick URL hack
        if ($userToken) {
            $apiUrl .= '?' . http_build_query(array(
                'api_key'  => $this->apiKey,
                'username' => $username,
                '_token'   => $userToken
            ));
        }

        echo "Requesting JSON: {$apiUrl}\n";
        $response = $this->getJson($apiUrl);
        //return $response;

        if (!empty($response->code) && $response->code === self::RESPONSE_OK) {
            foreach ($response->content->stories as $storyDoc) {

                // Get the embed content for each story
                $storySlug = $storyDoc->slug;
                $content = $this->getUserStoryEmbed($username, $storySlug);
                if ($content) {
                    $storyDoc->content = $content;
                }

                $story = new Story($storyDoc);
                $stories[] = $story;
            }
        }

        return $stories;
    }


    /**
        getUserStory -- returns the Storify document representing a user's story
    **/
    public function getUserStory($username, $storySlug)
    {
        $story  = null;
        $apiUrl = $this->expandUrlTemplate(
            self::URL_USER_STORY_ENDPOINT,
            array( 'username' => $username, 'slug' => $storySlug )
        );
        echo "Requesting JSON: $apiUrl\n";
        $response = $this->getJson($apiUrl);

        if (!empty($response->code) && $response->code === self::RESPONSE_OK) {
            $response = $response->content;
            $response->self = $apiUrl;

            $content = $this->getUserStoryEmbed($username, $storySlug);
            if ($content) {
                $response->content = $content;
            }

            $story = new Story($response);
        }

        return $story;
    }


    public function getStoryByUrl($storyUrl)
    {
        echo "Requesting JSON: $storyUrl\n";
        $response = $this->getJson($storyUrl);

        if (!empty($response->code) && $response->code === self::RESPONSE_OK) {
            $response = $response->content;
            $response->self = $storyUrl;

            $content = $this->getUserStoryEmbed($username, $storySlug);
            if ($content) {
                $response->content = $content;
            }
        }

        return $response;
    }


    public function getUserStoryEmbed($username, $slug)
    {
        $embedUrl = $this->expandUrlTemplate(
            self::URL_USER_STORY_EMBED,
            array( 'username' => $username, 'slug' => $slug )
        );
        $response = $this->getStoryEmbedByUrl($embedUrl);

        return $response;
    }


    public function getStoryEmbedByUrl($embedUrl)
    {
        echo "Requesting HTML: $embedUrl\n";
        $response = $this->getHTML($embedUrl);

        return $response;
    }


    // TODO: Should be in a utility/class method
    public function cleanUserStoryEmbed($embed)
    {
        $markup = $embed;

        // Chop off top and bottom: extract only ol.s-elements
        $endPos   = strpos($markup, '<a id="embed-footer"');
        $startPos = strpos($markup, '<ol class="s-elements">');
        //echo "[$startPos:$endPos]";
        $markup = substr($markup, $startPos, $endPos - $startPos);


        // Delete elements div.s-share-dropdown
        $markup = preg_replace('/<div class="s-share-dropdown">(.*?)<\/div>/', '', $markup);

        // Remove inline styles
        $markup = preg_replace('/ style="margin[^"]*"/', '', $markup);

        return $markup;

    }
}
