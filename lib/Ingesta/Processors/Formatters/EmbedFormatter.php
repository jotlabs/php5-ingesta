<?php
namespace Ingesta\Processors\Formatters;

use Ingesta\Services\Instagram\InstagramFactory;

class EmbedFormatter
{
    protected $config = null;
    protected $clients = array();


    public function __construct($config = null)
    {
        if ($config) {
            $this->setConfig($config);
        }
    }


    public function setConfig($config)
    {
        $this->config = $config;
    }


    public function isEmbedUrl($url)
    {
        $isEmbedUrl = false;

        if (strpos($url, 'instagram.com')) {
            $isEmbedUrl = true;
        } elseif (strpos($url, 'open.spotify.com')) {
            $isEmbedUrl = true;
        }

        return $isEmbedUrl;
    }


    public function embedUrl($url)
    {
        $output = '';
        if (strpos($url, 'instagram.com')) {
            $output = $this->getInstagramEmbed($url);
        } elseif (strpos($url, 'open.spotify.com')) {
            $output = $this->getSpotifyEmbed($url);
        }

        return $output;
    }


    public function getInstagramEmbed($url)
    {
        $output = $url;
        $instagram = $this->getInstagramClient();
        if (!empty($instagram)) {
            $data = $instagram->getMediaByWebUrl($url);
            // echo "Instagram media data: ";
            // print_r($data);
            if ($data) {
                if (!empty($data->videos)) {
                    echo "[VIDEO]\n";
                    $payload = <<<HTML
<video height="{$data->videos->standard_resolution->height}"
    width="{$data->videos->standard_resolution->width}"
    controls
    >
    <source src="{$data->videos->standard_resolution->url}" type="video/mp4">
</video>
HTML;
                } else {
                    $payload = <<<HTML
<a href="{$data->link}"><img
    src="{$data->images->standard_resolution->url}"
    width="{$data->images->standard_resolution->width}"
    height="{$data->images->standard_resolution->height}"
    alt=""></a>
HTML;
                }


                $output = <<<HTML
<div class="embed instagram">
    <div class="hd">
        <div class="user-profile">
            <a href="https://instagram.com/{$data->user->username}/">
                <img src="{$data->user->profile_picture}" alt="">
                {$data->user->username}
            </a>
        </div>
    </div>
    <div class="bd">
        {$payload}
    </div>
    <div class="ft">
        <div class="source">
            <a href="http://instagram.com/" class="from-instagram">Instagram</a>
        </div>
    </div>
</div>
HTML;
            }
        }

        return $output;
    }


    protected function getInstagramClient()
    {
        if (empty($this->clients['instagram'])) {
            $factory = new InstagramFactory();
            $config = $this->config->instagram;
            $this->clients['instagram'] = $factory->getInstagramClient($config->clientId);
        }

        return $this->clients['instagram'];
    }


    public function getSpotifyEmbed($url)
    {
        $output = $url;
        $embedUrl = $this->getSpotifyEmbedUrl($url);

        if ($embedUrl) {

            $output = <<<HTML
<div class="embed spotify">
    <iframe src="{$embedUrl}" width="640" height="720" frameborder="0" allowTransparency="true"></iframe>
</div>
HTML;
        }

        return $output;
    }


    protected function getSpotifyEmbedUrl($url)
    {
        $embedUrl = null;
        $spotifyRe = "/https?:\/\/open\.spotify\.com\/(track|album|user\/.+?\/playlist)\/([a-z0-9]{22})\/?/i";
        if (preg_match($spotifyRe, $url, $matches)) {
            $type = str_replace('/', ':', $matches[1]);
            $id = $matches[2];

            $spotifyUri = "spotify:{$type}:{$id}";
            $embedUrl = "https://embed.spotify.com/?uri={$spotifyUri}";
        }

        return $embedUrl;
    }
}
