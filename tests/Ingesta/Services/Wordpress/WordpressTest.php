<?php
namespace Ingesta\Services\Wordpress;

use PHPUnit_Framework_TestCase;
use Ingesta\Clients\XmlRpc\MockXmlRpcClient;
use Ingesta\Services\Wordpress\Credentials;

class WordpressTest extends PHPUnit_Framework_TestCase
{
    protected $wordpress;


    public function setUp()
    {
        $factory = new WordpressFactory();
        $factory->setTestMode(true);

        $mockClient = $this->setUpMockClient();
        $factory->setMockClient($mockClient);

        $credentials = new Credentials('testuser', 'password');

        $this->wordpress = $factory->getWordpressClient(
            'http://techcrunch.com/xmlrpc.php',
            $credentials
        );
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Wordpress\Wordpress'));
        $this->assertNotNull($this->wordpress);
        $this->assertTrue(is_a($this->wordpress, 'Ingesta\Services\Wordpress\Wordpress'));
    }


    public function testSayHelloReturnsResponse()
    {
        $response = $this->wordpress->sayHello();
        $this->assertNotNull($response);
        $this->assertEquals('Hello from mock xmlrpc client.', $response);
    }


    public function testGetWpPostsReturnsWordpressResponse()
    {
        $posts = $this->wordpress->getPosts();
        $this->assertNotNull($posts);
        $this->assertTrue(is_a($posts, 'Ingesta\Services\Wordpress\Wrappers\Posts'));
        $this->assertEquals(1, $posts->getNumberOfPosts());

        $post = $posts->getPost(0);
        $this->assertNotNull($post);
        $this->assertTrue(is_a($post, 'Ingesta\Services\Wordpress\Wrappers\Post'));
    }


    protected function setUpMockClient()
    {
        $mockClient = new MockXmlRpcClient('unit-test');

        $mockClient->addMethodResponse(
            'wp.getPosts',
            $this->getWpGetPostsResponse()
        );

        return $mockClient;
    }


    protected function getWpGetPostsResponse()
    {
        include STUB_DIR . '/xmlrpc-responses/wp-getPosts.php';
        return $response;
    }
}
