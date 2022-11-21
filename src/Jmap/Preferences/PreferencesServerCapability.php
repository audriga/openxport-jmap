<?php

namespace OpenXPort\Jmap\Preferences;

class PreferencesServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "https://www.audriga.eu/jmap/preferences/";
    }

    public function getMethods()
    {
        return array(
            "Preferences/get" => Methods\PreferencesGetMethod::class
        );
    }
}
