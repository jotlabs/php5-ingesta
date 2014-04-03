<?php
namespace Ingesta\Processors\Filters;

class DateFilter
{

    public function isDateAfter($item, $minDate)
    {
        $dateTs    = strtotime($item->getModifiedDate());
        $minDateTs = strtotime($minDate);
        //echo "[{$dateTs}:{$minDateTs}] ";
        //echo "[", $item->getModifiedDate(), ":{$minDate}] ";
        return ($dateTs > $minDateTs);
    }
}
