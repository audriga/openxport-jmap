<?php

namespace OpenXPort\Jmap\Contact;

class ContactsServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:contacts";
    }

    public function getMethods()
    {
        return array(
            "Contact/get" => Methods\ContactGetMethod::class,
            "Contact/set" => Methods\ContactSetMethod::class,
            "ContactGroup/get" => Methods\ContactGroupGetMethod::class,
            "AddressBook/get" => Methods\AddressBookGetMethod::class,
        );
    }
}
