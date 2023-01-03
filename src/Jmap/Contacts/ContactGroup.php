<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

class ContactGroup implements JsonSerializable
{
    protected $id;
    protected $addressBookId;
    protected $name;
    protected $contactIds;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAddressBookId()
    {
        return $this->addressBookId;
    }

    public function setAddressBookId($addressBookId)
    {
        $this->addressBookId = $addressBookId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContactIds()
    {
        return $this->contactIds;
    }

    public function setContactIds($contactIds)
    {
        $this->contactIds = $contactIds;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "addressBookId" => $this->getAddressBookId(),
            "name" => $this->getName(),
            "contactIds" => $this->getContactIds()
        ];
    }
}
