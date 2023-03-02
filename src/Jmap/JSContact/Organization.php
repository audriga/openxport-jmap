<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Organization extends TypeableEntity implements JsonSerializable
{
    /** @var string $name (optional) */
    private $name;

    /** @var OrgUnit[] $units (optional) */
    private $units;

    /** @var string $sortAs (optional) */
    private $sortAs;

    /** @var array<string, boolean> $contexts (optional)
     * The string keys of the array are of type Context
     * (see https://www.ietf.org/archive/id/draft-ietf-calext-jscontact-07.html#section-2.2.4-3.5)
     */
    private $contexts;

    public function __construct()
    {
        $this->atType = "Organization";
    }

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

    public function getSortAs()
    {
        return $this->sortAs;
    }

    public function setSortAs($sortAs)
    {
        $this->sortAs = $sortAs;
    }

    public function getContexts()
    {
        return $this->contexts;
    }

    public function setContexts($contexts)
    {
        $this->contexts = $contexts;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getAtType(),
            "name" => $this->getName(),
            "units" => $this->getUnits(),
            "sortAs" => $this->getSortAs(),
            "contexts" => $this->getContexts(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
