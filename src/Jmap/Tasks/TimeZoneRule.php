<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class TimeZoneRule implements JsonSerializable
{
    private $type;
    private $start;
    private $offsetFrom;
    private $offsetTo;
    private $recurrenceRules;
    private $recurrenceOverrides;
    private $names;
    private $comments;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getOffsetFrom()
    {
        return $this->offsetFrom;
    }

    public function setOffsetFrom($offsetFrom)
    {
        $this->offsetFrom = $offsetFrom;
    }

    public function getOffsetTo()
    {
        return $this->offsetTo;
    }

    public function setOffsetTo($offsetTo)
    {
        $this->offsetTo = $offsetTo;
    }

    public function getRecurrenceRules()
    {
        return $this->recurrenceRules;
    }

    public function setRecurrenceRules($recurrenceRules)
    {
        $this->recurrenceRules = $recurrenceRules;
    }

    public function getRecurrenceOverrides()
    {
        return $this->recurrenceOverrides;
    }

    public function setRecurrenceOverrides($recurrenceOverrides)
    {
        $this->recurrenceOverrides = $recurrenceOverrides;
    }

    public function getNames()
    {
        return $this->names;
    }

    public function setNames($names)
    {
        $this->names = $names;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "start" => $this->getStart(),
            "offsetFrom" => $this->getOffsetFrom(),
            "offsetTo" => $this->getOffsetTo(),
            "recurrenceRules" => $this->getRecurrenceRules(),
            "recurrenceOverrides" => $this->getRecurrenceOverrides(),
            "names" => $this->getNames(),
            "comments" => $this->getComments()
        ];
    }
}
