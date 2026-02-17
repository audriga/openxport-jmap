<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

class EmailAddress extends TypeableEntity implements JsonSerializable
{
    /**
     * address: String (mandatory).
     * The email address (addr-spec per RFC 5322).
     *
     * @var string
     */
    private $address;

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
        // @type MUST be "EmailAddress" if set.
        $this->setAtType('EmailAddress');
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
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
            "@type"    => $this->getAtType(),   // MUST be "EmailAddress" if present.
            "address"  => $this->getAddress(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
            "label"    => $this->getLabel(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
