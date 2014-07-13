<?php
namespace Ingesta\Processors\Formatters;

use Ingesta\Processors\Processor;

class WordpressContentFormatter implements Processor
{
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
            if ($line) {
                if (preg_match("/^\[caption ([^\]]+)\](.*)\[\/caption\]$/", $line, $matches)) {
                    //print_r($matches);
                    $buffer[] = "<div class=\"media-caption\">{$matches[2]}</div>";
                } elseif (strpos($line, '<p') === 0) {
                    // Do not wrap in paragraph tags
                } else {
                    $buffer[] = "<p>{$line}</p>";
                }
            }
        }

        return implode("\n", $buffer);
    }
}
