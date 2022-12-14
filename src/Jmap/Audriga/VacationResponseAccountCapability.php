<?php

namespace OpenXPort\Jmap\Audriga;

use OpenXPort\Jmap\Core\AccountCapability;

class VacationResponseAccountCapability extends AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();

        $this->name = "https://www.audriga.eu/jmap/vacationresponse/";
    }
}
