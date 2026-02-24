<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Name extends TypeableEntity implements JsonSerializable
{
    /** @var NameComponent[]|null components (optional) */
    private $components;

    /** @var bool|null isOrdered (optional; default: false) */
    private $isOrdered;

    /** @var string|null defaultSeparator (optional) */
    private $defaultSeparator;

    /** @var string|null full (optional) */
    private $full;

    /**
     * sortAs: String[String] (optional).
     * Keys: name component kind, values: verbatim string.
     *
     * @var array<string,string>|null
     */
    private $sortAs;

    /** @var string|null phoneticScript (optional) */
    private $phoneticScript;

    /** @var string|null phoneticSystem (optional) */
    private $phoneticSystem;

    public function __construct()
    {
        $this->setAtType('Name');
    }

    /**
     * @return NameComponent[]|null
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @param NameComponent[]|null $components
     */
    public function setComponents($components)
    {
        $this->components = $components;
    }

    public function getIsOrdered()
    {
        return $this->isOrdered;
    }

    public function setIsOrdered($isOrdered)
    {
        $this->isOrdered = $isOrdered;
    }

    public function getDefaultSeparator()
    {
        return $this->defaultSeparator;
    }

    public function setDefaultSeparator($defaultSeparator)
    {
        $this->defaultSeparator = $defaultSeparator;
    }

    public function getFull()
    {
        return $this->full;
    }

    public function setFull($full)
    {
        $this->full = $full;
    }

    /**
     * @return array<string,string>|null
     */
    public function getSortAs()
    {
        return $this->sortAs;
    }

    /**
     * @param array<string,string>|null $sortAs
     */
    public function setSortAs($sortAs)
    {
        $this->sortAs = $sortAs;
    }

    public function getPhoneticScript()
    {
        return $this->phoneticScript;
    }

    public function setPhoneticScript($phoneticScript)
    {
        $this->phoneticScript = $phoneticScript;
    }

    public function getPhoneticSystem()
    {
        return $this->phoneticSystem;
    }

    public function setPhoneticSystem($phoneticSystem)
    {
        $this->phoneticSystem = $phoneticSystem;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"            => $this->getAtType(),
            "isOrdered"        => $this->getIsOrdered(),
            "defaultSeparator" => $this->getDefaultSeparator(),
            "full"             => $this->getFull(),
            "sortAs"           => $this->getSortAs(),
            "phoneticScript"   => $this->getPhoneticScript(),
            "phoneticSystem"   => $this->getPhoneticSystem(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
