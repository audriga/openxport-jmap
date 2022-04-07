<?php

namespace OpenXPort\Jmap\Contact;

class ContactsAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:contacts";
    }
}
