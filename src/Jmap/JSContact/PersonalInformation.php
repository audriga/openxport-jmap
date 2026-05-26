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

    public function __construct($kind = null, $value = null, $level = null, $listAs = null, $label = null)
    {
        $this->setAtType('PersonalInfo');

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

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

        $instance = new self();

        if (isset($json->kind)) {
            $instance->setKind($json->kind);
        }
        if (isset($json->value)) {
            $instance->setValue($json->value);
        }
        if (isset($json->level)) {
            $instance->setLevel($json->level);
        }
        if (isset($json->listAs)) {
            $instance->setListAs($json->listAs);
        }

        return $instance;
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
