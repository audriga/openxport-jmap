<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class Participant implements JsonSerializable
{
    private $type;
    private $name;
    private $email;
    private $description;
    private $sendTo;
    private $kind;
    private $language;
    private $roles;
    private $locationId;
    private $participationStatus;
    private $participationComment;
    private $attendance;
    private $expectReply;
    private $scheduleSequence;
    private $scheduleUpdated;
    private $scheduleAgent;
    private $scheduleForceSend;
    private $scheduleStatus;
    private $sentBy;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
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

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
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

    public function getScheduleAgent()
    {
        return $this->scheduleAgent;
    }

    public function setScheduleAgent($scheduleAgent)
    {
        $this->scheduleAgent = $scheduleAgent;
    }

    public function getScheduleForceSend()
    {
        return $this->scheduleForceSend;
    }

    public function setScheduleForceSend($scheduleForceSend)
    {
        $this->scheduleForceSend = $scheduleForceSend;
    }

    public function getScheduleStatus()
    {
        return $this->scheduleStatus;
    }

    public function setScheduleStatus($scheduleStatus)
    {
        $this->scheduleStatus = $scheduleStatus;
    }

    public function getSentBy()
    {
        return $this->sentBy;
    }

    public function setSentBy($sentBy)
    {
        $this->sentBy = $sentBy;
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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "description" => $this->getDescription(),
            "sendTo" => $this->getSendTo(),
            "kind" => $this->getKind(),
            "language" => $this->getLanguage(),
            "roles" => $this->getRoles(),
            "locationId" => $this->getLocationId(),
            "participationStatus" => $this->getParticipationStatus(),
            "participationComment" => $this->getParticipationComment(),
            "attendance" => $this->getAttendance(),
            "expectReply" => $this->getExpectReply(),
            "scheduleSequence" => $this->getScheduleSequence(),
            "scheduleUpdated" => $this->getScheduleUpdated(),
            "scheduleAgent" => $this->getScheduleAgent(),
            "scheduleForceSend" => $this->getScheduleForceSend(),
            "scheduleStatus" => $this->getScheduleStatus(),
            "sentBy" => $this->getSentBy(),
            "invitedBy" => $this->getInvitedBy(),
            "delegatedTo" => $this->getDelegatedTo(),
            "delegatedFrom" => $this->getDelegatedFrom(),
            "memberOf" => $this->getMemberOf(),
            "linkIds" => $this->getLinkIds()
        ];
    }
}
