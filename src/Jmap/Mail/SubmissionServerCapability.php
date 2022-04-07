<?php

namespace OpenXPort\Jmap\Mail;

class SubmissionServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilites = array();
        $this->name = "urn:ietf:params:jmap:submission";
    }

    public function getMethods()
    {
        return array(
            "Identity/get" => Methods\IdentityGetMethod::class,
            "Identity/set" => Methods\IdentitySetMethod::class,
        );
    }
}
