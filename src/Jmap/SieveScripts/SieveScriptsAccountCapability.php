<?php

namespace OpenXPort\Jmap\SieveScript;

class SieveScriptsAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:sieve";
    }
}
