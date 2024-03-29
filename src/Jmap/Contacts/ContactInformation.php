<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class ContactInformation implements JsonSerializable
{
    private $type;
    private $label;
    private $value;
    private $isDefault;


    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        // TODO: Possibly do value checking of the parameter, since only enum values are allowed for this property
        $this->type = $type;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getIsDefault()
    {
        return $this->isDefault;
    }

    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "type" => $this->getType(),
            "label" => $this->getLabel(),
            "value" => $this->getValue(),
            "isDefault" => $this->getIsDefault()
        ], function ($val) {
            return !is_null($val);
        });
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        $this->name = AdapterUtil::reencode($this->name);
        $this->label = AdapterUtil::reencode($this->label);
        $this->value = AdapterUtil::reencode($this->value);
    }
}
