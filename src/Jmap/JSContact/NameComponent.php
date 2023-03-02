<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class NameComponent extends TypeableEntity implements JsonSerializable
{
    /** @var string $value (mandatory) */
    private $value;

    /** @var string $type (mandatory) */
    private $type;

    /** @var int $nth (optional, default: 1) */
    private $nth;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
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

    public function getNth()
    {
        return $this->nth;
    }

    public function setNth($nth)
    {
        $this->nth = $nth;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getAtType(),
            "value" => $this->getValue(),
            "type" => $this->getType(),
            "nth" => $this->getNth()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
