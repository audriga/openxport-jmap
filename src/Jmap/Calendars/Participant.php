<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class Participant implements JsonSerializable
{
    private $type;
    private $name;
    private $email;
    private $sendTo;
    private $kind;
    private $roles;
    private $locationId;
    private $participationStatus;
    private $participationComment;
    private $attendance;
    private $expectReply;
    private $scheduleSequence;
    private $scheduleUpdated;
    private $invitedBy;
    private $delegatedTo;
    private $delegatedFrom;
    private $memberOf;
    private $linkIds;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSendTo()
    {
        return $this->sendTo;
    }

    public function setSendTo($sendTo)
    {
        $this->sendTo = $sendTo;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    public function getParticipationStatus()
    {
        return $this->participationStatus;
    }

    public function setParticipationStatus($participationStatus)
    {
        $this->participationStatus = $participationStatus;
    }

    public function getParticipationComment()
    {
        return $this->participationComment;
    }

    public function setParticipationComment($participationComment)
    {
        $this->participationComment = $participationComment;
    }

    public function getAttendance()
    {
        return $this->attendance;
    }

    public function setAttendance($attendance)
    {
        $this->attendance = $attendance;
    }

    public function getExpectReply()
    {
        return $this->expectReply;
    }

    public function setExpectReply($expectReply)
    {
        $this->expectReply = $expectReply;
    }

    public function getScheduleSequence()
    {
        return $this->scheduleSequence;
    }

    public function setScheduleSequence($scheduleSequence)
    {
        $this->scheduleSequence = $scheduleSequence;
    }

    public function getScheduleUpdated()
    {
        return $this->scheduleUpdated;
    }

    public function setScheduleUpdated($scheduleUpdated)
    {
        $this->scheduleUpdated = $scheduleUpdated;
    }

    public function getInvitedBy()
    {
        return $this->invitedBy;
    }

    public function setInvitedBy($invitedBy)
    {
        $this->invitedBy = $invitedBy;
    }

    public function getDelegatedTo()
    {
        return $this->delegatedTo;
    }

    public function setDelegatedTo($delegatedTo)
    {
        $this->delegatedTo = $delegatedTo;
    }

    public function getDelegatedFrom()
    {
        return $this->delegatedFrom;
    }

    public function setDelegatedFrom($delegatedFrom)
    {
        $this->delegatedFrom = $delegatedFrom;
    }

    public function getMemberOf()
    {
        return $this->memberOf;
    }

    public function setMemberOf($memberOf)
    {
        $this->memberOf = $memberOf;
    }

    public function getLinkIds()
    {
        return $this->linkIds;
    }

    public function setLinkIds($linkIds)
    {
        $this->linkIds = $linkIds;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "sendTo" => $this->getSendTo(),
            "kind" => $this->getKind(),
            "roles" => $this->getRoles(),
            "locationId" => $this->getLocationId(),
            "participationStatus" => $this->getParticipationStatus(),
            "participationComment" => $this->getParticipationComment(),
            "attendance" => $this->getAttendance(),
            "expectReply" => $this->getExpectReply(),
            "scheduleSequence" => $this->getScheduleSequence(),
            "scheduleUpdated" => $this->getScheduleUpdated(),
            "invitedBy" => $this->getInvitedBy(),
            "delegatedTo" => $this->getDelegatedTo(),
            "delegatedFrom" => $this->getDelegatedFrom(),
            "memberOf" => $this->getMemberOf(),
            "linkIds" => $this->getLinkIds()
        ];
    }
}
