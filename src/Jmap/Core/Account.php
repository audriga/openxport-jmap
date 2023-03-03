<?php

namespace OpenXPort\Jmap\Core;

use JsonSerializable;

class Account implements JsonSerializable
{
    /** @var string */
    private $name;

    /** @var boolean */
    private $isPersonal;

    /** @var boolean */
    private $isReadOnly;

    /** @var array<string, Capability> */
    private $accountCapabilities;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getIsPersonal()
    {
        return $this->isPersonal;
    }

    public function setIsPersonal($isPersonal)
    {
        $this->isPersonal = $isPersonal;
    }

    public function getIsReadOnly()
    {
        return $this->isReadOnly;
    }

    public function setIsReadOnly($isReadOnly)
    {
        $this->isReadOnly = $isReadOnly;
    }

    public function getAccountCapabilities()
    {
        return $this->accountCapabilities;
    }

    public function setAccountCapabilities($accountCapabilities)
    {
        $this->accountCapabilities = $accountCapabilities;
    }
    
    public function jsonSerialize()
    {
        return (object)array_filter([
            "name" => $this->getName(),
            "isPersonal" => $this->getIsPersonal(),
            "isReadOnly" => $this->getIsReadOnly(),
            "accountCapabilities" => (object) $this->getAccountCapabilities()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
