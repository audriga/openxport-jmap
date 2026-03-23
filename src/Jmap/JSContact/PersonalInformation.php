<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class PersonalInformation extends TypeableEntity implements JsonSerializable
{
    private $type = 'PersonalInfo';
    /**
     * kind: String (mandatory).
     * Enum: expertise | hobby | interest.
     *
     * @var string
     */
    private $kind;

    /**
     * @var string $value (mandatory)
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

    public function __construct($kind, $value, $level = null, $listAs = null, $label = null)
    {
        $this->setKind($kind);
        $this->setValue($value);

        if ($level !== null) {
            $this->setLevel($level);
        }
        if ($listAs !== null) {
            $this->setListAs($listAs);
        }
        if ($label !== null) {
            $this->label = $label;
        }
    }

    public function getType(){
        return $this->type;
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
            "@type"  => $this->getAtType(),
            "kind"   => $this->getKind(),
            "value"  => $this->getValue(),
            "level"  => $this->getLevel(),
            "listAs" => $this->getListAs(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
