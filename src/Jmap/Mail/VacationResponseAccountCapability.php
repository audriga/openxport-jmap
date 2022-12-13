<?php

namespace OpenXPort\Jmap\Mail;

use OpenXPort\Jmap\Core\AccountCapability;

class VacationResponseAccountCapability extends AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();

        // TODO split into IETF capability and our extension
        $this->name = "urn:ietf:params:jmap:vacationresponse";
    }
}
