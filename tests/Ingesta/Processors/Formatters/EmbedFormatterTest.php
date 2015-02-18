<?php
namespace Ingesta\Processors\Formatters;

use PHPUnit_Framework_TestCase;
use Ingesta\Processors\Formatters\EmbedFormatter;

class EmbedFormatterTest extends PHPUnit_Framework_TestCase
{
    protected $formatter;


    public function setUp()
    {
        $this->formatter = new EmbedFormatter();
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Processors\Formatters\EmbedFormatter'));
        $this->assertNotNull($this->formatter);
        $this->assertTrue(is_a($this->formatter, 'Ingesta\Processors\Formatters\EmbedFormatter'));
    }

    public function testSpotifyEmbedEnabled()
    {
        $spotifyUrl = "http://open.spotify.com/user/spotify/playlist/2YeGkAUQhmO8TCjSMbFYWf";
        $expectedUrl = "https://embed.spotify.com/?uri=spotify:user:spotify:playlist:2YeGkAUQhmO8TCjSMbFYWf";

        $this->assertTrue($this->formatter->isEmbedUrl($spotifyUrl));

        $output = $this->formatter->embedUrl($spotifyUrl);
        $this->assertEquals(45, strpos($output, $expectedUrl));
        $this->assertEquals(32, strpos($output, '<iframe src'));
    }
}
