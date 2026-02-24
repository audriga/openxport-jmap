<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Title extends TypeableEntity implements JsonSerializable
{
    /**
     * name: String (mandatory).
     * The title or role name of the entity.
     *
     * @var string
     */
    private $name;

    /**
     * kind: String (optional; default: "title").
     * Enum: "title" | "role".
     *
     * @var string|null
     */
    private $kind = 'title';

    /**
     * organizationId: Id (optional).
     * Identifier of the organization in which this title is held.
     *
     * @var string|null
     */
    private $organizationId;

    public function __construct()
    {
        $this->setAtType('Title');
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"          => $this->getAtType(),
            "name"           => $this->getName(),
            "kind"           => $this->getKind(),
            "organizationId" => $this->getOrganizationId(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
