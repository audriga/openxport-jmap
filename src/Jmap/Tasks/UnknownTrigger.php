<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class UnknownTrigger implements JsonSerializable
{
    private $type;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
