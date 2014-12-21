<?php
namespace Ingesta\Processors\Formatters;

use Ingesta\Processors\Processor;

class WordpressContentFormatter implements Processor
{
    public static $blockEl = array(
        'address', 'article', 'aside', 'audio', 'blockquote', 'canvas',
        'dd', 'div', 'dl', 'fieldset', 'figcaption', 'figure', 'footer',
        'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'hgroup',
        'hr', 'li', 'noscript', 'ol', 'output', 'p', 'pre', 'section', 'table',
        'tfoot', 'ul', 'video'
    );


    public function process($input)
    {
        $content = $input->getContent();
        $content = $this->asHtml($content);
        $input->setContent($content);

        return $input;
    }


    protected function asHtml($content)
    {
        $buffer = array();
        $lines  = explode("\n", $content);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line) {
                if (preg_match("/^\[caption ([^\]]+)\](.*)\[\/caption\]$/", $line, $matches)) {
                    //print_r($matches);
                    $buffer[] = "<div class=\"media-caption\">{$matches[2]}</div>";

                } elseif (preg_match("/^\<img\s([^\>]+)\s\/\>$/", $line, $matches)) {
                    # A simple image
                    $buffer[] = "<div class=\"media-caption\">{$line}</div>";

                } elseif (preg_match("/^\[embed\]([^\]]*)\[\/embed\]$/", $line, $matches)) {
                    $buffer[] = $this->convertEmbed($matches[1]);

                } elseif (preg_match("/^\<\/?(\w+)\b/", $line, $match) && in_array($match[1], self::$blockEl)) {
                    // Do not wrap block level elements
                    $buffer[] = $line;

                } elseif (preg_match('/\S+/', $line)) {
                    $buffer[] = "<p>{$line}</p>";

                } else {
                    $buffer[] = $line;
                }
            }
        }

        $output = implode("\n", $buffer);
        return $output;
    }


    protected function convertEmbed($body)
    {
        $markup = "[embed]{$body}[/embed]";
        if (strpos($body, 'http') === 0) {

            if (strpos($body, 'youtube.com/') < 15 && preg_match('/\bv=([^&]+)/', $body, $matches)) {
                $videoId = $matches[1];
                //echo "Youtube clip: {$videoId}\n";
                $markup = $this->createYoutubeFigure($videoId);

            } else {
                echo "[-WARN-] Don't recognise embedded content: {$body}\n";
            }

        }

        return $markup;
    }


    protected function createYoutubeFigure($videoId)
    {
        $markup = <<<HTML
<figure class="video">
    <span class="container">
        <iframe width="560" height="315" src="//www.youtube.com/embed/{$videoId}"
            frameborder="0" allowfullscreen></iframe>
    </span>
</figure>
HTML;

        return $markup;
    }
}
