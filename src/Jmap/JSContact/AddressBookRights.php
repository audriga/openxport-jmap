<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class AddressBookRights implements JsonSerializable
{
    /** @var bool The user may fetch the ContactCards in this AddressBook. */
    protected $mayRead = false;

    /** @var bool The user may create/modify/destroy/move ContactCards in this AddressBook. */
    protected $mayWrite = false;

    /** @var bool The user may modify the "shareWith" property for this AddressBook. */
    protected $mayShare = false;

    /** @var bool The user may delete the AddressBook itself. */
    protected $mayDelete = false;

    public function getMayRead()
    {
        return $this->mayRead;
    }

    public function setMayRead($mayRead)
    {
        $this->mayRead = $mayRead;
    }

    public function getMayWrite()
    {
        return $this->mayWrite;
    }

    public function setMayWrite($mayWrite)
    {
        $this->mayWrite = $mayWrite;
    }

    public function getMayShare()
    {
        return $this->mayShare;
    }

    public function setMayShare($mayShare)
    {
        $this->mayShare = $mayShare;
    }

    public function getMayDelete()
    {
        return $this->mayDelete;
    }

    public function setMayDelete($mayDelete)
    {
        $this->mayDelete = $mayDelete;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) [
            'mayRead'   => $this->getMayRead(),
            'mayWrite'  => $this->getMayWrite(),
            'mayShare'  => $this->getMayShare(),
            'mayDelete' => $this->getMayDelete(),
        ];
    }
}
