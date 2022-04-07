<?php

namespace OpenXPort\Jmap\AudrigaDebug;

class AudrigaDebugServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "https://www.audriga.eu/jmap/debug/";
    }

    public function getMethods()
    {
        return array();
    }
}
