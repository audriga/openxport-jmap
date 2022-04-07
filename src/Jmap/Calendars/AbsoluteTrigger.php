<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class AbsoluteTrigger implements JsonSerializable
{
    private $type;
    private $when;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getWhen()
    {
        return $this->when;
    }

    public function setWhen($when)
    {
        $this->when = $when;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "when" => $this->getWhen()
        ];
    }
}
