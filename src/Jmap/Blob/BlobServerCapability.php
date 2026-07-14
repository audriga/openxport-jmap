<?php

namespace OpenXPort\Jmap\Blob;

class BlobServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:blob";
    }

    public function getMethods()
    {
        return array(
            "Blob/upload" => Methods\BlobUploadMethod::class,
            "Blob/get"    => Methods\BlobGetMethod::class
        );
    }
}
