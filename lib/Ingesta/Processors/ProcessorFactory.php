<?php
namespace Ingesta\Processors;

use Ingesta\Processors\Filters\DateFilter;
use Ingesta\Processors\Adapters\MethodCallAdapter;
use Ingesta\Processors\Formatters\SimpleBlogFormatter;

class ProcessorFactory
{
    const FILTER_UPDATED_SINCE_LAST_CHECK = 'updatedSinceLastCheck';
    const FORMAT_SIMPLE_BLOG_OUTPUT       = 'SimpleBlogFormat';

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
            $filter = $this->getFilter($processingRules->filter, $state);
            if ($filter) {
                echo "[-INFO-] Adding filter '{$processingRules->filter}'\n";
                $processor->addFilter($filter);
            } else {
                echo "\033[1;33m[-WARN-]\033[0m Filter '{$processingRules->filter}' not found.\n";
            }
        }

        if (!empty($processingRules->format)) {
            if (!is_array($processingRules->format)) {
                $processingRules->format = array($processingRules->format);
            }

            foreach ($processingRules->format as $format) {
                $formatter = $this->getFormatter($format, $state);
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
        }

        return $filter;
    }


    protected function getFormatter($formatName, $state)
    {
        $formatter = null;
        switch ($formatName) {
            case self::FORMAT_SIMPLE_BLOG_OUTPUT:
                $formatter = new SimpleBlogFormatter();
                break;
        }

        return $formatter;
    }
}
