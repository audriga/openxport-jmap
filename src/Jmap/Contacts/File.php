<?php

namespace Jmap\Contact;

use JsonSerializable;

class File implements JsonSerializable {

    /** @var string */
    private $blobId;

    /** @var string */
    private $type;

    /** @var string */
    private $name;

    /** @var int */
    private $size;
    
    public function getBlobId() {
        return $this->blobId;
    }

    public function setBlobId($blobId) {
        $this->blobId = $blobId;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function jsonSerialize() {
        return (object)[
            "blobId" => $this->getBlobId(),
            "type" => $this->getType(),
            "name" => $this->getName(),
            "size" => $this->getSize()
        ];
    }

}