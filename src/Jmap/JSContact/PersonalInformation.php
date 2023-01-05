<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class PersonalInformation extends TypeableEntity implements JsonSerializable
{
    /** @var string $type (mandatory) */
    private $type;

    /** @var string $value (mandatory) */
    private $value;

    /** @var string $level (optional) */
    private $level;

    /** @var string $label (optional) */
    private $label;

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

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
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
        return (object)[
            "@type" => $this->getAtType(),
            "type" => $this->getType(),
            "value" => $this->getValue(),
            "level" => $this->getLevel(),
            "label" => $this->getLabel()
        ];
    }
}
