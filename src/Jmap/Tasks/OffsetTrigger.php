<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class OffsetTrigger implements JsonSerializable
{
    private $type;
    private $offset;
    private $relativeTo;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function getRelativeTo()
    {
        return $this->relativeTo;
    }

    public function setRelativeTo($relativeTo)
    {
        $this->relativeTo = $relativeTo;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType(),
            "offset" => $this->getOffset(),
            "relativeTo" => $this->getRelativeTo()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
