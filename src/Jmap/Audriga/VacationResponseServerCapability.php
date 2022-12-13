<?php

namespace OpenXPort\Jmap\Audriga;

use OpenXPort\Jmap\Core\ServerCapability;

class VacationResponseServerCapability extends ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();

        $this->name = "https://www.audriga.eu/jmap/vacationresponse/";
    }

    public function getMethods()
    {
        return array(
            "VacationResponse/get" => Methods\VacationResponseGetMethod::class
        );
    }
}
