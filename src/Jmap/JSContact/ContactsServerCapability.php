<?php

namespace OpenXPort\Jmap\JSContact;

class ContactsServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "https://www.audriga.eu/jmap/jscontact/";
    }

    public function getMethods()
    {
        return array(
            "Card/get" => Methods\CardGetMethod::class,
            "Card/set" => Methods\CardSetMethod::class,
            "CardGroup/get" => Methods\CardGroupGetMethod::class,
            "CardGroup/set" => Methods\CardGroupSetMethod::class,
            "AddressBook/get" => Methods\AddressBookGetMethod::class,
            "AddressBook/set" => Methods\AddressBookSetMethod::class,
        );
    }
}
