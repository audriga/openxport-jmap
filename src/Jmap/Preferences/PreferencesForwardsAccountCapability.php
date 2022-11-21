<?php

namespace OpenXPort\Jmap\Preferences;

class PreferencesForwardsAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "https://www.audriga.eu/jmap/preferences-forwards/";
    }
}
