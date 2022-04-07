<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Relation extends TypeableEntity implements JsonSerializable
{
    /** @var array<string, boolean> $relation (optional) */
    private $relation;

    public function getRelation()
    {
        return $this->relation;
    }

    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "relation" => $this->getRelation()
        ];
    }
}
