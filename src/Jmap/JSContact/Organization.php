<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Organization extends TypeableEntity implements JsonSerializable
{
    /** @var string $name (mandatory) */
    private $name;

    /** @var string[] $units (optional) */
    private $units;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getUnits()
    {
        return $this->units;
    }

    public function setUnits($units)
    {
        $this->units = $units;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "name" => $this->getName(),
            "units" => $this->getUnits()
        ];
    }
}
