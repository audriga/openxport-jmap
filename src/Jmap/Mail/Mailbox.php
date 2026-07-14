<?php

namespace OpenXPort\Jmap\Mail;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

/**
 * Mailbox object as defined in RFC 8621 (JMAP for Mail).
 */
class Mailbox implements JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $parentId;

    /** @var string */
    private $role;

    /** @var int */
    private $sortOrder;

    /** @var int */
    private $totalEmails;

    /** @var int */
    private $unreadEmails;

    /** @var int */
    private $totalThreads;

    /** @var int */
    private $unreadThreads;

    /** @var bool */
    private $isSubscribed;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getTotalEmails()
    {
        return $this->totalEmails;
    }

    public function setTotalEmails($totalEmails)
    {
        $this->totalEmails = $totalEmails;
    }

    public function getUnreadEmails()
    {
        return $this->unreadEmails;
    }

    public function setUnreadEmails($unreadEmails)
    {
        $this->unreadEmails = $unreadEmails;
    }

    public function getTotalThreads()
    {
        return $this->totalThreads;
    }

    public function setTotalThreads($totalThreads)
    {
        $this->totalThreads = $totalThreads;
    }

    public function getUnreadThreads()
    {
        return $this->unreadThreads;
    }

    public function setUnreadThreads($unreadThreads)
    {
        $this->unreadThreads = $unreadThreads;
    }

    public function getIsSubscribed()
    {
        return $this->isSubscribed;
    }

    public function setIsSubscribed($isSubscribed)
    {
        $this->isSubscribed = $isSubscribed;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "id" => $this->getId(),
            "name" => $this->getName(),
            "parentId" => $this->getParentId(),
            "role" => $this->getRole(),
            "sortOrder" => $this->getSortOrder(),
            "totalEmails" => $this->getTotalEmails(),
            "unreadEmails" => $this->getUnreadEmails(),
            "totalThreads" => $this->getTotalThreads(),
            "unreadThreads" => $this->getUnreadThreads(),
            "isSubscribed" => $this->getIsSubscribed()
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
        $this->name = AdapterUtil::reencode($this->name);
    }
}
