<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Relation extends TypeableEntity implements JsonSerializable
{
    /**
     * relation: String[Boolean] (optional; default: empty Object).
     * Keys are relation types (friend, parent, spouse, ...).
     *
     * @var array<string,bool>|null
     */
    private $relation;

    public function __construct()
    {
        $this->setAtType('Relation');
    }

    /**
     * @return array<string,bool>|null
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @param array<string,bool>|null $relation
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    public function addRelationType($type)
    {
        if ($this->relation === null) {
            $this->relation = [];
        }
        $this->relation[$type] = true;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"    => $this->getAtType(),
            "relation" => is_null($this->getRelation()) ? (object) [] : $this->getRelation(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
