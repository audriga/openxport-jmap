<?php

namespace OpenXPort\Jmap\Note;

use JsonSerializable;

class Notebook implements JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var boolean */
    private $isSubscribed;

    /** @var boolean */
    private $isVisible;

    /** @var string */
    private $role;

    /** @var string */
    private $description;

    /** @var array */
    private $shareWith;

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

    public function getIsSubscribed()
    {
        return $this->isSubscribed;
    }

    public function setIsSubscribed($isSubscribed)
    {
        $this->isSubscribed = $isSubscribed;
    }

    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getShareWith()
    {
        return $this->shareWith;
    }

    public function setShareWith($shareWith)
    {
        $this->shareWith = $shareWith;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "name" => $this->getName(),
            "isSubscribed" => $this->getIsSubscribed(),
            "isVisible" => $this->getIsVisible(),
            "role" => $this->getRole(),
            "description" => $this->getDescription(),
            "shareWith" => $this->getShareWith()
        ];
    }
}
