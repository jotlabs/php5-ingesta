<?php
namespace Ingesta\Servers\XmlRpc;

class WeblogUpdates
{

    /**
    * Receives a blog update ping
    *
    * @param string $siteName
    * @param string $siteUrl
    * @param string $feedUrl
    * @return string
    **/
    public function extendedPing($siteName, $siteUrl, $feedUrl)
    {
        return "Hello";
    }
}
