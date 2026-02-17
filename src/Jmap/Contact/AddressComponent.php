<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

class AddressComponent extends TypeableEntity implements JsonSerializable
{
    /**
     * value: String (mandatory).
     * The value of the address component.
     *
     * @var string
     */
    private $value;

    /**
     * kind: String (mandatory).
     * Enumerated values (RFC 9553, AddressComponent kind): room, apartment,
     * floor, building, number, name, block, subdistrict, district, locality,
     * region, postcode, country, direction, landmark, postOfficeBox, separator.
     *
     * @var string
     */
    private $kind;

    /**
     * phonetic: String (optional).
     * Pronunciation of this component; requires phoneticScript or
     * phoneticSystem on the parent Address to be set.
     *
     * @var string|null
     */
    private $phonetic;

    public function __construct()
    {
        // @type MUST be "AddressComponent" if set.
        $this->setAtType('AddressComponent');
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getPhonetic()
    {
        return $this->phonetic;
    }

    public function setPhonetic($phonetic)
    {
        $this->phonetic = $phonetic;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"    => $this->getAtType(),   // MUST be "AddressComponent" if present.
            "value"    => $this->getValue(),
            "kind"     => $this->getKind(),
            "phonetic" => $this->getPhonetic(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
