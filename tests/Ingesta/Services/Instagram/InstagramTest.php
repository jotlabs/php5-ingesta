<?php
namespace Ingesta\Services\Instagram;

use PHPUnit_Framework_TestCase;
use Ingesta\Clients\Http\MockHttp;
use Ingesta\Utils\UrlTemplate;

class InstagramTest extends PHPUnit_Framework_TestCase
{
    const RECENT_TAG_DOC = '/service-responses/instagram-recent-tag.json';
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
    }


    public function testRecentTagReturnsObjectResponse()
    {
        $recentTags = $this->client->getRecentTag('mattdamon');
        $this->assertNotNull($recentTags);
    }


    protected function createMockHttpClient()
    {
        $httpClient = new MockHttp();

        $jsonDoc = file_get_contents(STUB_DIR . self::RECENT_TAG_DOC);
        $httpClient->addUrlResponse(
            'https://api.instagram.com/v1/tags/mattdamon/media/recent?client_id=' . self::MOCK_CLIENT_ID,
            $jsonDoc
        );

        return $httpClient;
    }
}
