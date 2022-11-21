<?php

namespace OpenXPort\Jmap\Preferences;

class PreferencesForwardsServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "https://www.audriga.eu/jmap/preferences-forwards/";
    }

    public function getMethods()
    {
        return array(
            "Preferences/get" => Methods\PreferencesGetMethod::class
        );
    }
}
