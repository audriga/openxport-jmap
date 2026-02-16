<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Phone extends TypeableEntity implements JsonSerializable
{
    /**
     * number: String (mandatory).
     * Phone number as URI or free text.
     *
     * @var string
     */
    private $number;

    /**
     * features: String[Boolean] (optional).
     *
     * @var array<string,bool>|null
     */
    private $features;

    /**
     * contexts: String[Boolean] (optional).
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

    /**
     * label: String (optional).
     *
     * @var string|null
     */
    private $label;

    public function __construct()
    {
        // @type MUST be "Phone" if set.
        $this->setAtType('Phone');
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return array<string,bool>|null
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param array<string,bool>|null $features
     */
    public function setFeatures($features)
    {
        $this->features = $features;
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

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"    => $this->getAtType(),   // MUST be "Phone" if present.
            "number"   => $this->getNumber(),
            "features" => $this->getFeatures(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
            "label"    => $this->getLabel(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
