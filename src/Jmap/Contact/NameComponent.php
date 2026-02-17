<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

class NameComponent extends TypeableEntity implements JsonSerializable
{
    /** @var string value (mandatory) */
    private $value;

    /**
     * kind: String (mandatory).
     * One of: title, given, given2, surname, surname2, credential, generation, separator.
     *
     * @var string
     */
    private $kind;

    /**
     * phonetic: String (optional).
     *
     * @var string|null
     */
    private $phonetic;

    public function __construct()
    {
        // RFC 9553: if @type is set, MUST be "NameComponent".
        $this->setAtType('NameComponent');
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
            "@type"    => $this->getAtType(), // MUST be "NameComponent" if present.
            "value"    => $this->getValue(),
            "kind"     => $this->getKind(),
            "phonetic" => $this->getPhonetic(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
