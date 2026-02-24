<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class AddressBook implements JsonSerializable
{
    /** @var string|null Id (immutable; server-set) */
    protected $id;

    /**
     * Optional type hint (implementation-specific, not defined in RFC 9610),
     * e.g. "ietf", "legacy", etc.
     *
     * @var string|null
     */
    protected $type;

    /** @var string User-visible name (non-empty, <= 255 UTF-8 octets) */
    protected $name;

    /** @var string|null Optional long-form description */
    protected $description;

    /**
     * sortOrder: UnsignedInt (default: 0).
     *
     * Lower values sort before higher in UI.[web:155]
     *
     * @var int
     */
    protected $sortOrder = 0;

    /**
     * isDefaultean (server-set).
     *
     * True for at most one AddressBook per account.[web:182]
     *
     * @var bool
     */
    protected $isDefault = false;

    /**
     * isSubscribedean.
     *
     * True if the user wants to see this AddressBook in the client.[web:155][web:56]
     *
     * @var bool
     */
    protected $isSubscribed = true;

    /**
     * shareWith: Id[AddressBookRights]|null (default: null).[web:155]
     *
     * @var array<string,AddressBookRights>|null
     */
    protected $shareWith;

    /**
     * myRights: AddressBookRights (server-set).[web:155]
     *
     * @var AddressBookRights|null
     */
    protected $myRights;

    /* Getters/setters */

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getIsDefault()
    {
        return $this->isDefault;
    }

    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
    }

    public function getIsSubscribed()
    {
        return $this->isSubscribed;
    }

    public function setIsSubscribed($isSubscribed)
    {
        $this->isSubscribed = $isSubscribed;
    }

    /**
     * @return array<string,AddressBookRights>|null
     */
    public function getShareWith()
    {
        return $this->shareWith;
    }

    /**
     * @param array<string,AddressBookRights>|null $shareWith
     */
    public function setShareWith($shareWith)
    {
        $this->shareWith = $shareWith;
    }

    public function getMyRights()
    {
        return $this->myRights;
    }

    public function setMyRights($myRights)
    {
        $this->myRights = $myRights;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            'id'           => $this->getId(),
            'type'         => $this->getType(),
            'name'         => $this->getName(),
            'description'  => $this->getDescription(),
            'sortOrder'    => $this->getSortOrder(),
            'isDefault'    => $this->getIsDefault(),
            'isSubscribed' => $this->getIsSubscribed(),
            'shareWith'    => $this->getShareWith(),
            'myRights'     => $this->getMyRights(),
        ], function ($val) {
            return !is_null($val);
        });
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        $this->name        = AdapterUtil::reencode($this->name);
        $this->description = AdapterUtil::reencode($this->description);
    }
}
