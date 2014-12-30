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
        }

        return $isEmbedUrl;
    }


    public function embedUrl($url)
    {
        $output = '';
        if (strpos($url, 'instagram.com')) {
            $output = $this->getInstagramEmbed($url);
        }

        return $output;
    }


    public function getInstagramEmbed($url)
    {
        $output = $url;
        $instagram = $this->getInstagramClient();
        if (!empty($instagram)) {
            $data = $instagram->getMediaByWebUrl($url);
            //echo "Instagram media data: ";
            //print_r($data);

            $output = <<<HTML
<div class="embed instagram">
    <div class="hd">
        <a href="https://instagram.com/{$data->user->username}/"><img src="{$data->user->profile_picture}" alt="">{$data->user->username}</a>
    </div>
    <div class="bd">
        <a href="{$data->link}"><img
            src="{$data->images->standard_resolution->url}"
            width="{$data->images->standard_resolution->width}"
            height="{$data->images->standard_resolution->height}"
            alt=""></a>
        <p>{$data->caption->text}</p>
    </div>
    <div class="ft">
        <a href="http://instagram.com/" class="from-instagram">Instagram</a>
    </div>
</div>
HTML;

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
}
