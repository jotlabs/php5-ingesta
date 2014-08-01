<?php
namespace Ingesta\Services\Storify\Utils;

class Content
{

    public static function cleanStoryContent($content)
    {
        $markup = $content;

        // Chop off top and bottom: extract only ol.s-elements
        $startPos = strpos($markup, '<ol class="s-elements">');
        $endPos   = strpos($markup, '<a id="embed-footer"');
        $markup   = substr($markup, $startPos, $endPos - $startPos);

        // Delete elements div.s-share-dropdown
        $markup = preg_replace('/<div class="s-share-dropdown">(.*?)<\/div>/', '', $markup);

        // Remove inline styles
        $markup = preg_replace('/ style="margin[^"]*"/', '', $markup);

        return $markup;
    }
}
