<?php

namespace OpenXPort\Jmap\Task;

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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType(),
            "when" => $this->getWhen()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
