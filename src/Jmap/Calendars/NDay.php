<?php

namespace OpenXPort\Jmap\Calendar;

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

    // always lowercase
    public function setDay($day)
    {
        $this->day = strtolower($day);
    }

    public function getNthOfPeriod()
    {
        return $this->nthOfPeriod;
    }

    public function setNthOfPeriod($nthOfPeriod)
    {
        $this->nthOfPeriod = $nthOfPeriod;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "day" => $this->getDay(),
            "nthOfPeriod" => $this->getNthOfPeriod()
        ];
    }
}
