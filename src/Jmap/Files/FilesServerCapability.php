<?php

namespace OpenXPort\Jmap\Files;

class FilesServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:filenode";
    }

    public function getMethods()
    {
        return array(
            "FileNode/get" => Methods\FileNodeGetMethod::class,
            "FileNode/query" => Methods\FileNodeQueryMethod::class,
            "FileNode/set" => Methods\FileNodeSetMethod::class,
            "FileNode/changes" => Methods\FileNodeChangesMethod::class,
            "FileNode/queryChanges" => Methods\FileNodeQueryChangesMethod::class,
            "FileNode/copy" => Methods\FileNodeCopyMethod::class
        );
    }
}
