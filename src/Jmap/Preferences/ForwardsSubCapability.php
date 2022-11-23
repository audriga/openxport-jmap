<?php

namespace OpenXPort\Jmap\Preferences;

class ForwardsSubCapability extends \OpenXPort\Jmap\Core\Capability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "https://www.audriga.eu/jmap/preferences-forwards/";
    }
}
