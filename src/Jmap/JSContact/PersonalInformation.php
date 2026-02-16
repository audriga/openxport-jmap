<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class PersonalInformation extends TypeableEntity implements JsonSerializable
{
    /**
     * kind: String (mandatory).
     * Enum: expertise | hobby | interest. 
     *
     * @var string
     */
    private $kind;

    /**
     * value: String (mandatory).
     *
     * @var string
     */
    private $value;

    /**
     * level: String (optional).
     * Enum: high | medium | low. 
     *
     * @var string|null
     */
    private $level;

    /**
     * listAs: UnsignedInt (optional).
     *
     * @var int|null
     */
    private $listAs;

    /**
     * label: String (optional).
     *
     * @var string|null
     */
    private $label;

    public function __construct()
    {
        // @type MUST be "PersonalInfo" if set. 
        $this->setAtType('PersonalInfo');
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getListAs()
    {
        return $this->listAs;
    }

    public function setListAs($listAs)
    {
        $this->listAs = $listAs;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"  => $this->getAtType(),   // MUST be "PersonalInfo" if present. 
            "kind"   => $this->getKind(),
            "value"  => $this->getValue(),
            "level"  => $this->getLevel(),
            "listAs" => $this->getListAs()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
