<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class File implements JsonSerializable
{
    /** @var string */
    protected $blobId;

    /** @var string */
    protected $type;

    /** @var string */
    protected $name;

    /** @var int */
    protected $size;

    // Additional property
    // See
    // * https://web.audriga.com/mantis/view.php?id=5071 and
    // * https://web.audriga.com/mantis/view.php?id=5337
    protected $base64;

    public function getBlobId()
    {
        return $this->blobId;
    }

    public function setBlobId($blobId)
    {
        $this->blobId = $blobId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getBase64()
    {
        return $this->base64;
    }

    public function setBase64($base64)
    {
        $this->base64 = $base64;
    }

    public function jsonSerialize()
    {
        return (object)[
            "blobId" => $this->getBlobId(),
            "type" => $this->getType(),
            "name" => $this->getName(),
            "size" => $this->getSize(),
            "base64" => $this->getBase64()
        ];
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        $this->name = AdapterUtil::reencode($this->name);
    }
}
