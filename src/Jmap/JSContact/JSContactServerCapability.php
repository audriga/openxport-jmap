<?php

namespace OpenXPort\Jmap\JSContact;

class JSContactServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
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
            "ContactCard/query" => Methods\ContactCardQueryMethod::class,
            "ContactCard/changes" => Methods\ContactCardChangesMethod::class,
            "AddressBook/get" => Methods\AddressBookGetMethod::class,
            "AddressBook/set" => Methods\AddressBookSetMethod::class,
            "AddressBook/query" => Methods\AddressBookQueryMethod::class
        );
    }
}
