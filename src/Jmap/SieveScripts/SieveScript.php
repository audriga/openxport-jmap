<?php

namespace OpenXPort\Jmap\SieveScript;

use JsonSerializable;

class SieveScript implements JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $blobId;

    /** @var boolean */
    private $isActive;

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

    public function getBlobId()
    {
        return $this->blobId;
    }

    public function setBlobId($blobId)
    {
        $this->blobId = $blobId;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "id" => $this->getId(),
            "name" => $this->getName(),
            "blobId" => $this->getBlobId(),
            "isActive" => $this->getIsActive()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
