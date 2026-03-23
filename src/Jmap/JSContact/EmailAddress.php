<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class EmailAddress extends TypeableEntity implements JsonSerializable
{   
    private $type = 'EmailAddress';
    /**
     * address: String (mandatory).
     * The email address.
     *
     * @var string
     */
    private $address;

    /**
     * @var array<string, boolean> $contexts (optional)
     *
     * @var array<string,bool>|null
     */
    private $contexts;

    /** @var int $pref (optional)
     * The int here is the Preference type
     */
    private $pref;

    /* @var string $label (optional)
     *
     * @var string|null
     */
    private $label;

    public function __construct($address = null, $contexts = null, $pref = null, $label = null)
    {
        $this->setAddress($address);

        if ($contexts !== null) {
            $this->setContexts($contexts);
        }
        if ($pref !== null) {
            $this->setPref($pref);
        }
        if ($label !== null) {
            $this->setLabel($label);
        }
    }

    public function getType()
    {
        return $this->type;
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
            "@type"    => $this->getAtType(),
            "address"  => $this->getAddress(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
            "label"    => $this->getLabel(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
