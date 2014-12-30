<?php
namespace Ingesta\Processors;

use Ingesta\Processors\Filters\DateFilter;
use Ingesta\Processors\Filters\DraftFilter;
use Ingesta\Processors\Adapters\MethodCallAdapter;
use Ingesta\Processors\Formatters\SimpleBlogFormatter;
use Ingesta\Processors\Formatters\WordpressContentFormatter;
use Ingesta\Processors\Formatters\EmbedFormatter;

class ProcessorFactory
{
    const FILTER_UPDATED_SINCE_LAST_CHECK = 'updatedSinceLastCheck';
    const FILTER_IS_PUBLISHED             = 'isPublished';
    const FORMAT_SIMPLE_BLOG_OUTPUT       = 'SimpleBlogFormat';
    const FORMAT_WORDPRESS_CONTENT        = 'WordpressContentFormat';

    protected static $INSTANCE;


    protected function __construct()
    {
    }


    public static function getInstance()
    {
        if (!self::$INSTANCE) {
            self::$INSTANCE = new ProcessorFactory();
        }

        return self::$INSTANCE;
    }


    public function getProcessor($processingRules, $state = null)
    {
        $processor = new InputProcessor();

        if (!empty($processingRules->filter)) {
            if (!is_array($processingRules->filter)) {
                $processingRules->filter = array($processingRules->filter);
            }

            foreach ($processingRules->filter as $filterName) {
                $filter = $this->getFilter($filterName, $state);
                if ($filter) {
                    echo "[-INFO-] Adding filter '{$filterName}'\n";
                    $processor->addFilter($filter);
                } else {
                    echo "\033[1;33m[-WARN-]\033[0m Filter '{$filterName}' not found.\n";
                }
            }

        }

        if (!empty($processingRules->format)) {
            if (!is_array($processingRules->format)) {
                $processingRules->format = array($processingRules->format);
            }

            $embeds = null;
            if (!empty($processingRules->embeds)) {
                $embeds = $processingRules->embeds;
            }

            foreach ($processingRules->format as $format) {
                $formatter = $this->getFormatter($format, $embeds, $state);
                if ($formatter) {
                    echo "[-INFO-] Adding formatter '{$format}'\n";
                    $processor->addFormatter($formatter);
                } else {
                    echo "\033[1;33m[-WARN-]\033[0m Formatter '{$format}' not found.\n";
                }
            }
        }

        return $processor;
    }


    protected function getFilter($filterName, $state)
    {
        $filter = null;
        switch ($filterName) {
            case self::FILTER_UPDATED_SINCE_LAST_CHECK:
                $dateFilter = new DateFilter();
                $filter     = new MethodCallAdapter(
                    array($dateFilter, 'isDateAfter'),
                    //array('20140328T12:00:00')
                    array(
                        empty($state->lastRun) ? 0 : $state->lastRun
                    )
                );
                break;
            case self::FILTER_IS_PUBLISHED:
                $filter = new DraftFilter();
                break;
        }

        return $filter;
    }


    protected function getFormatter($formatName, $embeds, $state)
    {
        $formatter = null;
        switch ($formatName) {
            case self::FORMAT_SIMPLE_BLOG_OUTPUT:
                $formatter = new SimpleBlogFormatter();
                break;
            case self::FORMAT_WORDPRESS_CONTENT:
                $formatter = new WordpressContentFormatter();
                $embed = new EmbedFormatter($embeds);
                $formatter->setEmbed($embed);
                break;
        }

        return $formatter;
    }
}
