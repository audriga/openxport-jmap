<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class Address implements JsonSerializable
{
    private $type;
    private $label;
    private $street;
    private $locality;
    private $region;
    private $postcode;
    private $country;
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

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getLocality()
    {
        return $this->locality;
    }

    public function setLocality($locality)
    {
        $this->locality = $locality;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        $this->region = $region;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
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
            "street" => $this->getStreet(),
            "locality" => $this->getLocality(),
            "region" => $this->getRegion(),
            "postcode" => $this->getPostcode(),
            "country" => $this->getCountry(),
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
        $this->label = AdapterUtil::reencode($this->label);
        $this->street = AdapterUtil::reencode($this->street);
        $this->locality = AdapterUtil::reencode($this->locality);
        $this->region = AdapterUtil::reencode($this->region);
        $this->country = AdapterUtil::reencode($this->country);
    }
}
