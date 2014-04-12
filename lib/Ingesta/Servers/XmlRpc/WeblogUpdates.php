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
    * @param string $category
    * @return struct
    **/
    public function extendedPing($siteName, $siteUrl, $feedUrl = '', $category = '')
    {
        return array(
            'flerror' => false,
            'message' => "Thanks for the ping, {$siteName}."
        );
    }
}
