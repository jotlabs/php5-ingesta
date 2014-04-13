<?php
namespace Ingesta\Clients\Http;

use Ingesta\Clients\Http;

class HttpBase implements Http
{

    public function get($url)
    {
        $data = '';

        if ($this->isHttpUrl($url)) {
            $data = @file_get_contents($url);

        } elseif ($this->isFilePath($url)) {
            echo __CLASS__ . " File Read $url\n";
            $data = @file_get_contents($url);

        } else {
            // No idea what this URL is.
        }

        return $data;
    }



    protected function isHttpUrl($url)
    {
        $isHttpUrl = false;

        if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
            $isHttpUrl = true;
        }

        return $isHttpUrl;
    }


    protected function isFilePath($url)
    {
        $isLocalFile = false;

        if (is_file($url)) {
            $isLocalFile = true;
        }

        return $isLocalFile;
    }
}
