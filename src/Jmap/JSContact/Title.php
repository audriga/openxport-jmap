<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Title extends TypeableEntity implements JsonSerializable
{
    /**
     * @var string $title (mandatory)
     */
    private $name;

    /**
     * @var string|null
     */
    private $kind = 'title';

    /**
     * @var string $organizationId (optional)
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

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

        $instance = new self();

        if (isset($json->name)) {
            $instance->setName($json->name);
        }
        if (isset($json->kind)) {
            $instance->setKind($json->kind);
        }
        if (isset($json->organizationId)) {
            $instance->setOrganizationId($json->organizationId);
        }

        return $instance;
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
