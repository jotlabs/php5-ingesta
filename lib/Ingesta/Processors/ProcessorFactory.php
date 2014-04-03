<?php
namespace Ingesta\Processors;

use Ingesta\Processors\Filters\DateFilter;
use Ingesta\Processors\Adapters\MethodCallAdapter;

class ProcessorFactory
{
    const FILTER_UPDATED_SINCE_LAST_CHECK = 'updatedSinceLastCheck';

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
                $processor->addFilter($filter);
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
                    array($state->lastRun)
                );
                break;
        }

        return $filter;
    }
}
