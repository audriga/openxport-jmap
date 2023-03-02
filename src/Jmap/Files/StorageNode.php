<?php

namespace OpenXPort\Jmap\Files;

use OpenXPort\Util\AdapterUtil;

class StorageNode implements \JsonSerializable
{
    /**
     * @var string is either ID or root, trash or temp
     * **/
    private $id;

    /** @var string **/
    private $parentId;

    /** @var string **/
    private $blobId;

    /** @var string **/
    private $name;

    /**
     * Content type
     * @var string
     * **/
    private $type;

    /** @var int **/
    private $size;

    /** @var int **/
    private $created;

    /** @var int **/
    private $modified;

    /** Comment added by user
     * @var string **/
    private $description;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
    }

    public function getBlobId()
    {
        return $this->blobId;
    }

    public function setBlobId($id)
    {
        $this->blobId = $id;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getModified()
    {
        return $this->modified;
    }

    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    # NOTE Sharing and permissions not implemented
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "id" => $this->id,
            "parentId" => $this->parentId,
            "blobId" => $this->blobId,
            "name" => $this->name,
            "type" => $this->type,
            "size" => $this->size,
            "created" => $this->created,
            "modified" => $this->modified,
            "description" => $this->description
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
        $this->description = AdapterUtil::reencode($this->description);
    }
}
