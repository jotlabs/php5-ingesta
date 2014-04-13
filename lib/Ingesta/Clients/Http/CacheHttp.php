<?php
namespace Ingesta\Clients\Http;

use Ingesta\Clients\Http;

class CacheHttp implements Http
{
    protected $httpClient;
    protected $cacheDir;
    protected $expiryLimit = 0;

    protected $config = array(
        'cacheDir' => '/tmp/httpcache/'
    );
    protected $slugifyCache = array();

    // Slugify URL pattern matches
    protected $patterns     = array(
        '/^https?:\/\//',
        '/[^a-zA-Z0-9]+/'
    );
    protected $replacements = array(
        '',  # 1. Trim off protocol and double slashes
        '-', # 2. Replace non alphanumerics with single dash
    );


    public function __construct($httpClient, $cacheDir)
    {
        $this->httpClient = $httpClient;
        $this->cacheDir   = $cacheDir;

        $this->init();
    }


    public function setExpiryLimit($limit)
    {
        if (is_int($limit)) {
            $this->expiryLimit = intval($limit);
        }
    }


    public function get($url)
    {
        $data = '';

        if ($this->isCachedUrl($url)) {
            $data = $this->getCachedUrl($url);

        } else {
            $data = $this->httpClient->get($url);
            if ($data) {
                $this->saveCachedUrl($url, $data);
            }
        }

        return $data;
    }


    protected function getCachedUrl($url)
    {
        $data = '';

        $slug     = $this->_slugifyUrl($url);
        $filePath = $this->cacheDir . $slug;

        if (is_file($filePath)) {
            $data = file_get_contents($filePath);
        }

        return $data;
    }


    protected function saveCachedUrl($url, $data)
    {
        $slug     = $this->slugifyUrl($url);
        $filePath = $this->cacheDir . $slug;
        file_put_contents($filePath, $data);
    }


    protected function isCachedUrl($url)
    {
        $isCached = false;

        if ($this->isHttpUrl($url)) {
            $slug      = $this->slugifyUrl($url);
            $filePath  = $this->cacheDir . $slug;
            //$isCached = file_exists($filePath);

            if (is_file($filePath)) {
                // Check age of cache
                $age = time() - filemtime($filePath);
                if ($this->expiryLimit && $age > $this->expiryLimit) {
                    //echo "CACHED: $slug ({$age}:{$expires})\n";
                } else {
                    //echo "CACHED: $slug\n";
                    $isCached = true;
                }
            }

        }

        return $isCached;
    }


    protected function slugifyUrl($url)
    {
        if (empty($this->slugifyCache[$url])) {
            $slug = $url;

            // Replace query string in url with an MD5 string
            $slug = preg_replace_callback('/\?.+/', function ($m) {
                return md5($m[0]);
            }, $url);

            // Run through standard regexes
            $slug = preg_replace($this->patterns, $this->replacements, $slug);
            $this->slugifyCache[$url] = $slug;
        }
        return $this->slugifyCache[$url];
    }


    protected function isHttpUrl($url)
    {
        $isHttpUrl = false;

        if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
            $isHttpUrl = true;
        }

        return $isHttpUrl;
    }


    protected function init()
    {
        $this->initCacheDir($this->cacheDir);
    }


    protected function initCacheDir($cacheDir)
    {
        if (is_dir($cacheDir)) {
            // Everything is okay
        } elseif (file_exists($cacheDir)) {
            // File exists of that name - this is an error
            throw new InvalidCacheException("Cache directory '{$cacheDir}' is a file.");
        } else {
            mkdir($cacheDir, 0777, true);
        }
    }
}
