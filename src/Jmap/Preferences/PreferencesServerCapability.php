<?php

namespace OpenXPort\Jmap\Preferences;

class PreferencesServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct($subCapabilities)
    {
        $this->capabilities = array(
            'subCapabilities' => array(),
        );

        foreach ($subCapabilities as $cap) {
            $this->capabilities["subCapabilities"][$cap->getName()] = $cap;
        }

        $this->name = "https://www.audriga.eu/jmap/preferences/";
    }

    public function getMethods()
    {
        return array(
            "Preferences/get" => Methods\PreferencesGetMethod::class
        );
    }
}
