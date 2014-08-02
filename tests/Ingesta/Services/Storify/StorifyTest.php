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


    public function testGetUserStoryReturnsStory()
    {
        $story = $this->storify->getUserStory('unittest', 'teststory');
        $this->assertNotNull($story);
        $this->assertTrue(is_a($story, 'Ingesta\Services\Storify\Wrappers\Story'));

        $this->assertNotNull($story->getStoryId());
        $this->assertNotNull($story->getGuid());
        $this->assertNotNull($story->getTitle());
        $this->assertNotNull($story->getSlug());
        $this->assertNotNull($story->getStatus());

        $this->assertNotNull($story->getLink());
        $this->assertNotNull($story->getDescription());
        $this->assertNotNull($story->getThumbnail());
        $this->assertNotNull($story->getCreatedDate());
        $this->assertNotNull($story->getModifiedDate());
        $this->assertNotNull($story->getPublishedDate());
        $this->assertNotNull($story->getTags());

        $this->assertNotNull($story->getAuthor());
        $this->assertNotNull($story->getApiUrl());
        $this->assertNotNull($story->getContent());


        $this->assertTrue($story->isPublished());
        $this->assertTrue(is_array($story->getTags()));

        $tags = $story->getTags();
        $this->assertTrue(count($tags) > 0);

        foreach ($tags as $tag) {
            $this->assertTrue($tag[0] !== '#');
        }


        $author = $story->getAuthor();
        $this->assertNotNull($author->slug);
        $this->assertNotNull($author->name);
        $this->assertNotNull($author->bio);
        $this->assertNotNull($author->image);
        $this->assertNotNull($author->location);
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
