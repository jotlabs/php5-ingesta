<?php
namespace Ingesta\Services\Storify;

use PHPUnit_Framework_TestCase;
use Ingesta\Clients\Http\MockHttp;

class StorifyTest extends PHPUnit_Framework_TestCase
{
    protected $storify;

    public function setUp()
    {
        $factory = StorifyFactory::getInstance();
        $factory->setTestMode(true);

        $mockHttpClient = $this->initMockHttpClient();
        $factory->setMockHttpClient($mockHttpClient);

        $this->storify = $factory->getStorifyClient();
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Storify\Storify'));
        $this->assertNotNull($this->storify);
        $this->assertTrue(is_a($this->storify, 'Ingesta\Services\Storify\Storify'));
    }


    public function testGetUserStoryReturnsUserStory()
    {
        $story = $this->storify->getUserStory('unittest', 'teststory');
        $this->assertNotNull($story);
        $this->assertNotNull($story->self);
        $this->assertNotNull($story->content);
    }


    protected function initMockHttpClient()
    {
        $httpClient = new MockHttp();

        $httpClient->addUrlResponse(
            'http://api.storify.com/v1/stories/unittest/teststory',
            file_get_contents(STUB_DIR . '/service-responses/storify-get-user-story-RAW.json')
        );

        $httpClient->addUrlResponse(
            'http://storify.com/unittest/teststory/embed',
            file_get_contents(STUB_DIR . '/service-responses/storify-get-user-story-embed.html')
        );

        return $httpClient;
    }
}
