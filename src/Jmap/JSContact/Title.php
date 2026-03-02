<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Title extends TypeableEntity implements JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $kind = 'title';

    /**
     * @var string|null
     */
    private $organizationId;

    public function __construct($name = null, $kind = null, $organizationId = null)
    {
        $this->setAtType('Title');

        if ($name !== null) {
            $this->name = $name;
        }
        if ($kind !== null) {
            $this->kind = $kind;
        }
        if ($organizationId !== null) {
            $this->organizationId = $organizationId;
        }
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
            '@type'          => $this->getAtType(),
            'name'           => $this->getName(),
            'kind'           => $this->getKind(),
            'organizationId' => $this->getOrganizationId(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
