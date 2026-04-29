<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class NameComponent extends TypeableEntity implements JsonSerializable
{
    /**
     * @var string|null
     */
    private $kind;

    /**
     * @var string|null
     */
    private $value;

    public function __construct($kind = null, $value = null)
    {
        $this->setAtType('NameComponent');

        if ($kind !== null) {
            $this->kind = $kind;
        }
        if ($value !== null) {
            $this->value = $value;
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

        return $instance;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            '@type' => $this->getAtType(),
            'kind'  => $this->getKind(),
            'value' => $this->getValue(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
