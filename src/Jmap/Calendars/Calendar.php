<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class Calendar implements JsonSerializable
{
    private $id;
    private $name;
    private $description;
    private $color;
    private $sortOrder;
    private $isVisible;
    private $shareWith;
    private $role;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    public function getShareWith()
    {
        return $this->shareWith;
    }

    public function setShareWith($shareWith)
    {
        $this->shareWith = $shareWith;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "color" => $this->getColor(),
            "sortOrder" => $this->getSortOrder(),
            "isVisible" => $this->getIsVisible(),
            "shareWith" => $this->getShareWith(),
            "role" => $this->getRole()
        ];
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        $this->name = AdapterUtil::reencode($this->name);
        $this->description = AdapterUtil::reencode($this->description);
    }
}
