<?php

namespace OpenXPort\Jmap\Mail;

class MailAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:mail";
    }
}
