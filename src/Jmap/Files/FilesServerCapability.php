<?php

namespace OpenXPort\Jmap\Files;

class FilesServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:files";
    }

    public function getMethods()
    {
        return array(
            "StorageNode/get" => Methods\StorageNodeGetMethod::class,
            "StorageNode/query" => Methods\StorageNodeQueryMethod::class
        );
    }
}
