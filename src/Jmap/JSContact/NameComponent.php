<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class NameComponent extends TypeableEntity implements JsonSerializable
{
    private $type = "NameComponent";
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
        if ($kind !== null) {
            $this->kind = $kind;
        }
        if ($value !== null) {
            $this->value = $value;
        }
    }

    public function getType()
    {
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
