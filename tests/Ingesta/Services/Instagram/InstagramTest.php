<?php
namespace Ingesta\Services\Instagram;

use PHPUnit_Framework_TestCase;
use Ingesta\Clients\Http\MockHttp;
use Ingesta\Utils\UrlTemplate;

class InstagramTest extends PHPUnit_Framework_TestCase
{
    const RECENT_TAG_DOC = '/service-responses/instagram-recent-tag.json';
    const MEDIA_RESPONSE_DOC = '/service-responses/instagram-media-response.json';
    const MOCK_CLIENT_ID = 'INSTAGRAM_CLIENT_ID';
    protected $client;


    public function setUp()
    {
        $httpClient   = $this->createMockHttpClient();
        $urlTemplate  = new UrlTemplate();
        $clientId     = self::MOCK_CLIENT_ID;
        $this->client = new Instagram($httpClient, $urlTemplate);
        $this->client->setApiClientId($clientId);
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Instagram\Instagram'));
        $this->assertNotNull($this->client);
        $this->assertTrue(is_a($this->client, 'Ingesta\Services\Instagram\Instagram'));
        $this->assertTrue(is_a($this->client, 'Ingesta\Inputs\InputGetter'));
    }


    public function testRecentTagReturnsObjectResponse()
    {
        $recentMedia = $this->client->getRecentByTag('mattdamon');
        $this->assertNotNull($recentMedia);
        $this->assertTrue(is_a($recentMedia, 'Ingesta\Services\Instagram\Wrappers\PaginatedResults'));
        $this->assertTrue(is_a($recentMedia, 'IteratorAggregate'));

        foreach ($recentMedia as $media) {
            $this->assertNotNull($media);
            $this->assertTrue(is_a($media, 'Ingesta\Services\Instagram\Wrappers\MediaResult'));

            $this->assertNotNull($media->getGuid());
            $this->assertNotNull($media->getLink());
            $this->assertNotNull($media->getTitle());
            $this->assertNotNull($media->getPublishedDate());
            $this->assertNotNull($media->getStandardImage());

            $author = $media->getAuthor();
            $this->assertNotNull($author);

            $this->assertTrue(is_integer($media->getLikeCount()));
            $this->assertTrue(is_integer($media->getCommentCount()));
        }
    }


    public function testGetMediaShortcodeFromUrl()
    {
        $itemUrl = 'http://instagram.com/p/tQt9joJaX0/?modal=true';
        $itemId = $this->client->getMediaShortcodeFromUrl($itemUrl);
        $this->assertEquals('tQt9joJaX0', $itemId);
    }


    public function testGetItemData()
    {
        $itemUrl = 'http://instagram.com/p/tQt9joJaX0/?modal=true';

        $itemData = $this->client->getMediaByWebUrl($itemUrl);
        $this->assertNotNull($itemData);

        //print_r($itemData);

        $this->assertNotNull($itemData->link);
        $this->assertNotNull($itemData->id);

        $this->assertNotNull($itemData->caption);
        $this->assertNotNull($itemData->caption->text);

        $this->assertNotNull($itemData->user->username);
        $this->assertNotNull($itemData->user->profile_picture);
        $this->assertNotNull($itemData->user->full_name);

        $this->assertNotNull($itemData->images->standard_resolution->url);
        $this->assertEquals(640, $itemData->images->standard_resolution->width);
        $this->assertEquals(640, $itemData->images->standard_resolution->height);
    }


    protected function createMockHttpClient()
    {
        $httpClient = new MockHttp();

        $recentTagsDoc = file_get_contents(STUB_DIR . self::RECENT_TAG_DOC);
        $httpClient->addUrlResponse(
            'https://api.instagram.com/v1/tags/mattdamon/media/recent?client_id=' . self::MOCK_CLIENT_ID,
            $recentTagsDoc
        );

        $mediaResponseDoc = file_get_contents(STUB_DIR . self::MEDIA_RESPONSE_DOC);
        $httpClient->addUrlResponse(
            'https://api.instagram.com/v1/media/shortcode/tQt9joJaX0?client_id=' . self::MOCK_CLIENT_ID,
            $mediaResponseDoc
        );
        return $httpClient;
    }
}
