<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class NDay implements JsonSerializable
{
    private $type;
    private $day;
    private $nthOfPeriod;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
    {
        $this->day = $day;
    }

    public function getNthOfPeriod()
    {
        return $this->nthOfPeriod;
    }

    public function setNthOfPeriod($nthOfPeriod)
    {
        $this->nthOfPeriod = $nthOfPeriod;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType(),
            "day" => $this->getDay(),
            "nthOfPeriod" => $this->getNthOfPeriod()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
