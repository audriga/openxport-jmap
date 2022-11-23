<?php

namespace OpenXPort\Jmap\Preferences;

class BlocklistSubCapability extends \OpenXPort\Jmap\Core\Capability
{
    public function __construct()
    {
        $this->capabilities = array(
            'allowIps' => false,
            'allowDomains' => false,
            'allowWildcards' => false,
        );
        $this->name = "https://www.audriga.eu/jmap/preferences-blocklist/";
    }
}
