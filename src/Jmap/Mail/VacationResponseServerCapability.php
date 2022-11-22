<?php

namespace OpenXPort\Jmap\Mail;

use OpenXPort\Jmap\Core\ServerCapability;

class VacationResponseServerCapability extends ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:vacationresponse";
    }

    public function getMethods()
    {
        return array(
            "VacationResponse/get" => Methods\VacationResponseGetMethod::class
        );
    }
}
