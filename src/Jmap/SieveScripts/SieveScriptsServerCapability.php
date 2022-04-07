<?php

namespace OpenXPort\Jmap\SieveScript;

class SieveScriptsServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:sieve";
    }

    public function getMethods()
    {
        return array(
            "SieveScript/get" => Methods\SieveScriptGetMethod::class,
            "SieveScript/set" => Methods\SieveScriptSetMethod::class
        );
    }
}
