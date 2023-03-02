<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class Relation implements JsonSerializable
{
    private $type;
    private $relation;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getRelation()
    {
        return $this->relation;
    }

    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType(),
            "relation" => $this->getRelation()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
