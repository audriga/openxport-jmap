<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class StreetComponent extends TypeableEntity implements JsonSerializable
{
    /** @var string $type (mandatory) */
    private $type;

    /** @var string $value (mandatory) */
    private $value;

    public function __construct($type = null, $value = null)
    {
        $this->atType = "StreetComponent";
        $this->type = $type;
        $this->value = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
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
            "@type" => $this->getAtType(),
            "type" => $this->getType(),
            "value" => $this->getValue()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
