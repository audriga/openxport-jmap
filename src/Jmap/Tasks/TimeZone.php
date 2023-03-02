<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class TimeZone implements JsonSerializable
{
    private $type;
    private $tzId;
    private $updated;
    private $url;
    private $validUntil;
    private $aliases;
    private $standard;
    private $daylight;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getTzId()
    {
        return $this->tzId;
    }

    public function setTzId($tzId)
    {
        $this->tzId = $tzId;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getValidUntil()
    {
        return $this->validUntil;
    }

    public function setValidUntil($validUntil)
    {
        $this->validUntil = $validUntil;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }

    public function getStandard()
    {
        return $this->standard;
    }

    public function setStandard($standard)
    {
        $this->standard = $standard;
    }

    public function getDaylight()
    {
        return $this->daylight;
    }

    public function setDaylight($daylight)
    {
        $this->daylight = $daylight;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType(),
            "tzId" => $this->getTzId(),
            "updated" => $this->getUpdated(),
            "url" => $this->getUrl(),
            "validUntil" => $this->getValidUntil(),
            "aliases" => $this->getAliases(),
            "standard" => $this->getStandard(),
            "daylight" => $this->getDaylight()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
