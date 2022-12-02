<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class RecurrenceRule implements JsonSerializable
{
    private $type;
    private $frequency;
    private $interval;
    private $rscale;
    private $skip;
    private $firstDayOfWeek;
    private $byDay;
    private $byMonthDay;
    private $byMonth;
    private $byYearDay;
    private $byWeekNo;
    private $byHour;
    private $byMinute;
    private $bySecond;
    private $bySetPosition;
    private $count;
    private $until;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }

    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    public function getInterval()
    {
        return $this->interval;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    public function getRscale()
    {
        return $this->rscale;
    }

    public function setRscale($rscale)
    {
        $this->rscale = $rscale;
    }

    public function getSkip()
    {
        return $this->skip;
    }

    public function setSkip($skip)
    {
        $this->skip = $skip;
    }

    public function getFirstDayOfWeek()
    {
        return $this->firstDayOfWeek;
    }

    public function setFirstDayOfWeek($firstDayOfWeek)
    {
        $this->firstDayOfWeek = $firstDayOfWeek;
    }

    public function getByDay()
    {
        return $this->byDay;
    }

    public function setByDay($byDay)
    {
        $this->byDay = $byDay;
    }

    public function getByMonthDay()
    {
        return $this->byMonthDay;
    }

    public function setByMonthDay($byMonthDay)
    {
        $this->byMonthDay = $byMonthDay;
    }

    public function getByMonth()
    {
        return $this->byMonth;
    }

    public function setByMonth($byMonth)
    {
        $this->byMonth = $byMonth;
    }

    public function getByYearDay()
    {
        return $this->byYearDay;
    }

    public function setByYearDay($byYearDay)
    {
        $this->byYearDay = $byYearDay;
    }

    public function getByWeekNo()
    {
        return $this->byWeekNo;
    }

    public function setByWeekNo($byWeekNo)
    {
        $this->byWeekNo = $byWeekNo;
    }

    public function getByHour()
    {
        return $this->byHour;
    }

    public function setByHour($byHour)
    {
        $this->byHour = $byHour;
    }

    public function getByMinute()
    {
        return $this->byMinute;
    }

    public function setByMinute($byMinute)
    {
        $this->byMinute = $byMinute;
    }

    public function getBySecond()
    {
        return $this->bySecond;
    }

    public function setBySecond($bySecond)
    {
        $this->bySecond = $bySecond;
    }

    public function getBySetPosition()
    {
        return $this->bySetPosition;
    }

    public function setBySetPosition($bySetPosition)
    {
        $this->bySetPosition = $bySetPosition;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getUntil()
    {
        return $this->until;
    }

    public function setUntil($until)
    {
        $this->until = $until;
    }
    
    /**
     * Parses a CalendarEvent object from the given JSON representation.
     * 
     * @param mixed $json String/Array containing a calendar event in the JSCalendar format.
     * 
     * @return CalendarEvent CalendarEvent object containing any properties that can be
     * parsed from the given JSON string/array.
     */
    public static function fromJson($json)
    {
        $classInstance = new RecurrenceRule();

        if (is_string($json)) {
            $json = json_decode($json);
        }

        if (is_array($json)){
            return self::fromJsonArray($json);
        }

        foreach ($json as $key => $value) {
            if (!property_exists($classInstance, $key)) {
                // TODO: Should probably add a logger to each class that can be called here.
                continue;
            }

            // Since all of the properties are private, using this will allow access to the setter
            // functions of any given property. 
            // Caution! In order for this to work, every setter method needs to match the property
            // name. So for a var fooBar, the setter needs to be named setFooBar($fooBar).
            $setPropertyMethod = "set" . ucfirst($key);

            if (!method_exists($classInstance, $setPropertyMethod)) {
                // TODO: same as with property check, add a logger maybe.
                continue;
            }

            // Access the setter method of the given property.
            $classInstance->{"$setPropertyMethod"}($value);
        }

        return $classInstance;
    }

    /**
     * Used by fromJson() to parse an array of JSON RecurrenceRule objects, as they are stored in a
     * recurrenceRule[] array in the JSCalendar format.
     */
     private static function fromJsonArray(array $json)
    {
        $jsonEntries = [];

        foreach ($json as $entry) {
            array_push($jsonEntries, self::fromJson($entry));
        }

        return $jsonEntries;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "frequency" => $this->getFrequency(),
            "interval" => $this->getInterval(),
            "rscale" => $this->getRscale(),
            "skip" => $this->getSkip(),
            "firstDayOfWeek" => $this->getFirstDayOfWeek(),
            "byDay" => $this->getByDay(),
            "byMonthDay" => $this->getByMonthDay(),
            "byMonth" => $this->getByMonth(),
            "byYearDay" => $this->getByYearDay(),
            "byWeekNo" => $this->getByWeekNo(),
            "byHour" => $this->getByHour(),
            "byMinute" => $this->getByMinute(),
            "bySecond" => $this->getBySecond(),
            "bySetPosition" => $this->getBySetPosition(),
            "count" => $this->getCount(),
            "until" => $this->getUntil()
        ];
    }
}
