<?php

namespace OpenXPort\Jmap\Files;

class FilesAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:files";
    }
}
