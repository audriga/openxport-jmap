<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class OrgUnit extends TypeableEntity implements JsonSerializable
{
    /** @var string $name (optional) */
    private $name;

    /** @var string $sortAs (optional) */
    private $sortAs;

    public function __construct()
    {
        $this->atType = "OrgUnit";
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSortAs()
    {
        return $this->sortAs;
    }

    public function setSortAs($sortAs)
    {
        $this->sortAs = $sortAs;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->atType,
            "name" => $this->name,
            "sortAs" => $this->sortAs,
        ], function ($val) {
            return !is_null($val);
        });
    }
}
