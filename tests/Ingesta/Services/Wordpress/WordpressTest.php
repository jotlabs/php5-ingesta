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
        $factory = WordpressFactory::getInstance();
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


    public function testGetWpPostsReturnsArrayOfWordpressPosts()
    {
        $posts = $this->wordpress->getPosts();
        $this->assertNotNull($posts);
        $this->assertTrue(is_array($posts));
        $this->assertEquals(1, count($posts));

        $post = $posts[0];
        $this->assertNotNull($post);
        $this->assertTrue(is_a($post, 'Ingesta\Services\Wordpress\Wrappers\Post'));

        $this->assertNotNull($post->getPostId());
        $this->assertNotNull($post->getTitle());
        $this->assertNotNull($post->getLink());
        $this->assertNotNull($post->getContent());
    }


    public function testGetWpPostReturnsWordpressResponse()
    {
        $post = $this->wordpress->getPost(1);
        $this->assertNotNull($post);
        $this->assertTrue(is_a($post, 'Ingesta\Services\Wordpress\Wrappers\Post'));

        $this->assertNotNull($post->getPostId());
        $this->assertNotNull($post->getTitle());
        $this->assertNotNull($post->getLink());
        $this->assertNotNull($post->getContent());
    }


    protected function setUpMockClient()
    {
        $mockClient = new MockXmlRpcClient('unit-test');


        $mockClient->addMethodResponse(
            'wp.getPosts',
            $this->getWpGetPostsResponse()
        );


        $mockClient->addMethodResponse(
            'wp.getPost',
            $this->getWpGetPostResponse()
        );

        return $mockClient;
    }


    protected function getWpGetPostsResponse()
    {
        include STUB_DIR . '/xmlrpc-responses/wp-getPosts.php';
        return $response;
    }


    protected function getWpGetPostResponse()
    {
        include STUB_DIR . '/xmlrpc-responses/wp-getPost.php';
        return $response;
    }
}
