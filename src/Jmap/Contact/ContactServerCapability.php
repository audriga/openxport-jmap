<?php

namespace OpenXPort\Jmap\Contact;

class ContactServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:contacts";
    }

    public function getMethods()
    {
        return array(
            "ContactCard/get" => Methods\ContactCardGetMethod::class,
            "ContactCard/set" => Methods\ContactCardSetMethod::class,
            "AddressBook/get" => Methods\AddressBookGetMethod::class,
            "AddressBook/set" => Methods\AddressBookSetMethod::class,
        );
    }
}
