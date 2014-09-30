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


    public function post($url, $params)
    {
        $data = '';

        if ($this->isHttpUrl($url)) {
            $ch = curl_init();

            $postBody = $this->urlEncodeParams($params);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);

            $data = curl_exec($ch);
            curl_close($ch);

        } else {
            // No idea what this URL is.
        }

        return $data;
    }


    protected function urlEncodeParams($params)
    {
        $query = http_build_query($params);
        return $query;
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
