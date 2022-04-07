<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Address extends TypeableEntity implements JsonSerializable
{
    /** @var string $fullAddress (optional) */
    private $fullAddress;

    /** @var StreetComponent[] $street (optional) */
    private $street;

    /** @var string $locality (optional) */
    private $locality;

    /** @var string $region (optional) */
    private $region;

    /** @var string $country (optional) */
    private $country;

    /** @var string $postcode (optional) */
    private $postcode;

    /** @var string $countryCode (optional) */
    private $countryCode;

    /** @var string $coordinates (optional) */
    private $coordinates;

    /** @var string $timeZone (optional) */
    private $timeZone;

    /** @var array<string, boolean> $contexts (optional)
     * The string keys of the array are of type Context
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.1)
     */
    private $contexts;

    /** @var int $pref (optional)
     * The int here is the Preference type
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.4)
     */
    private $pref;

    /** @var string $label (optional) */
    private $label;

    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    public function setFullAddress($fullAddress)
    {
        $this->fullAddress = $fullAddress;
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

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public function getContexts()
    {
        return $this->contexts;
    }

    public function setContexts($contexts)
    {
        $this->contexts = $contexts;
    }

    public function getPref()
    {
        return $this->pref;
    }

    public function setPref($pref)
    {
        $this->pref = $pref;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "fullAddress" => $this->getFullAddress(),
            "street" => $this->getStreet(),
            "locality" => $this->getLocality(),
            "region" => $this->getRegion(),
            "country" => $this->getCountry(),
            "postcode" => $this->getPostcode(),
            "countryCode" => $this->getCountryCode(),
            "coordinates" => $this->getCoordinates(),
            "timeZone" => $this->getTimeZone(),
            "contexts" => $this->getContexts(),
            "pref" => $this->getPref(),
            "label" => $this->getLabel()
        ];
    }
}
