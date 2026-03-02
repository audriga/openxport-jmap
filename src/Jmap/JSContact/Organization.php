<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Organization extends TypeableEntity implements JsonSerializable
{
    /** @var string|null name (optional) */
    private $name;

    /** @var OrgUnit[]|null units (optional) */
    private $units;

    /** @var string|null sortAs (optional) */
    private $sortAs;

    /**
     * contexts: String[Boolean] (optional).
     *
     * @var array<string,bool>|null
     */
    private $contexts;

    public function __construct(
        $name = null,
        $units = null,
        $sortAs = null,
        $contexts = null
    ) {
        $this->setAtType('Organization');

        if ($name !== null) {
            $this->setName($name);
        }
        if ($units !== null) {
            $this->setUnits($units);
        }
        if ($sortAs !== null) {
            $this->setSortAs($sortAs);
        }
        if ($contexts !== null) {
            $this->setContexts($contexts);
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

    /**
     * @return OrgUnit[]|null
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param OrgUnit[]|null $units
     */
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

    /**
     * @return array<string,bool>|null
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @param array<string,bool>|null $contexts
     */
    public function setContexts($contexts)
    {
        $this->contexts = $contexts;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"    => $this->getAtType(),
            "name"     => $this->getName(),
            "units"    => $this->getUnits(),
            "sortAs"   => $this->getSortAs(),
            "contexts" => $this->getContexts(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
