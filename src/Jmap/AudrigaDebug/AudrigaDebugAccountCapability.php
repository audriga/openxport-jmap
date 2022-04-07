<?php

namespace OpenXPort\Jmap\AudrigaDebug;

class AudrigaDebugAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "https://www.audriga.eu/jmap/debug/";
    }
}
