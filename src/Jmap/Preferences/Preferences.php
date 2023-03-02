<?php

namespace OpenXPort\Jmap\Preferences;

use JsonSerializable;

class Preferences implements JsonSerializable
{
    /** @var string $id */
    private $id;

    /** @var string[]|null $blocklistMail */
    private $blocklistMail;

    /** @var string[]|null $blocklistIp */
    private $blocklistIp;

    /** @var string[]|null $allowlistMail */
    private $allowlistMail;

    /** @var string[]|null $allowlistIp */
    private $allowlistIp;

    /** @var \OpenXPort\Jmap\Preferences\Forward[]|null $forwards */
    private $forwards;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getBlocklistMail()
    {
        return $this->blocklistMail;
    }

    public function setBlocklistMail($blocklistMail)
    {
        $this->blocklistMail = $blocklistMail;
    }

    public function getBlocklistIp()
    {
        return $this->blocklistIp;
    }

    public function setBlocklistIp($blocklistIp)
    {
        $this->blocklistIp = $blocklistIp;
    }

    public function getAllowlistMail()
    {
        return $this->allowlistMail;
    }

    public function setAllowlistMail($allowlistMail)
    {
        $this->allowlistMail = $allowlistMail;
    }

    public function getAllowlistIp()
    {
        return $this->allowlistIp;
    }

    public function setAllowlistIp($allowlistIp)
    {
        $this->allowlistIp = $allowlistIp;
    }

    public function getForwards()
    {
        return $this->forwards;
    }

    public function setForwards($forwards)
    {
        $this->forwards = $forwards;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "id" => $this->getId(),
            "blocklistMail" => $this->getBlocklistMail(),
            "blocklistIp" => $this->getBlocklistIp(),
            "allowlistMail" => $this->getAllowlistMail(),
            "allowlistIp" => $this->getAllowlistIp(),
            "forwards" => $this->getForwards()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
