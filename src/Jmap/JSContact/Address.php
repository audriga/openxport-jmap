<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Address extends TypeableEntity implements JsonSerializable
{
    /** @var AddressComponent[]|null components (optional) */
    private $components;

    /** @var bool|null isOrdered (optional; default: false) */
    private $isOrdered;

    /** @var string|null defaultSeparator (optional) */
    private $defaultSeparator;

    /** @var string|null full (optional) */
    private $fullAddress;

    /** @var string|null countryCode (optional) */
    private $countryCode;

    /** @var string|null coordinates (optional, "geo:" URI) */
    private $coordinates;

    /** @var string|null timeZone (optional, IANA TZ name) */
    private $timeZone;

    /**
     * contexts: String[Boolean] (optional).
     * Keys are Context values, all values MUST be true.
     *
     * @var array<string,bool>|null
     */
    private $contexts;

    /**
     * pref: UnsignedInt (optional).
     *
     * @var int|null
     */
    private $pref;

    /** @var string|null phoneticScript (optional) */
    private $phoneticScript;

    /** @var string|null phoneticSystem (optional) */
    private $phoneticSystem;

    public function __construct()
    {
        $this->setAtType('Address');
    }

    /**
     * @return AddressComponent[]|null
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @param AddressComponent[]|null $components
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

    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    public function setFullAddress($fullAddress)
    {
        $this->fullAddress = $fullAddress;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
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

    public function getPref()
    {
        return $this->pref;
    }

    public function setPref($pref)
    {
        $this->pref = $pref;
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
            "components"       => $this->getComponents(),
            "isOrdered"        => $this->getIsOrdered(),
            "defaultSeparator" => $this->getDefaultSeparator(),
            "full"             => $this->getFullAddress(),
            "countryCode"      => $this->getCountryCode(),
            "coordinates"      => $this->getCoordinates(),
            "timeZone"         => $this->getTimeZone(),
            "contexts"         => $this->getContexts(),
            "pref"             => $this->getPref(),
            "phoneticScript"   => $this->getPhoneticScript(),
            "phoneticSystem"   => $this->getPhoneticSystem(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
