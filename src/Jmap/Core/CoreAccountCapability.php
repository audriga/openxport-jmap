<?php

namespace OpenXPort\Jmap\Core;

class CoreAccountCapability extends AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:core";
    }
}
