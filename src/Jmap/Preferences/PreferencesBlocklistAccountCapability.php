<?php

namespace OpenXPort\Jmap\Preferences;

class PreferencesBlocklistAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array(
            'allowIps' => true,
            'allowDomains' => true,
            'allowWildcards' => true
        );
        $this->name = "https://www.audriga.eu/jmap/preferences-blocklist/";
    }
}
