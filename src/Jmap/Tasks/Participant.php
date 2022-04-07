<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class Participant implements JsonSerializable
{
    private $type;
    private $name;
    private $email;
    private $description;
    private $sendTo;
    private $kind;
    private $roles;
    private $locationId;
    private $language;
    private $participationStatus;
    private $participationComment;
    private $expectReply;
    private $scheduleAgent;
    private $scheduleForceSend;
    private $scheduleSequence;
    private $scheduleStatus;
    private $scheduleUpdated;
    private $invitedBy;
    private $delegatedTo;
    private $delegatedFrom;
    private $memberOf;
    private $links;
    private $progress;
    private $progressUpdated;
    private $percentComplete;

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

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
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

    public function getExpectReply()
    {
        return $this->expectReply;
    }

    public function setExpectReply($expectReply)
    {
        $this->expectReply = $expectReply;
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

    public function getScheduleSequence()
    {
        return $this->scheduleSequence;
    }

    public function setScheduleSequence($scheduleSequence)
    {
        $this->scheduleSequence = $scheduleSequence;
    }

    public function getScheduleStatus()
    {
        return $this->scheduleStatus;
    }

    public function setScheduleStatus($scheduleStatus)
    {
        $this->scheduleStatus = $scheduleStatus;
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

    public function getLinks()
    {
        return $this->links;
    }

    public function setLinks($links)
    {
        $this->links = $links;
    }

    public function getProgress()
    {
        return $this->progress;
    }

    public function setProgress($progress)
    {
        $this->progress = $progress;
    }

    public function getProgressUpdated()
    {
        return $this->progressUpdated;
    }

    public function setProgressUpdated($progressUpdated)
    {
        $this->progressUpdated = $progressUpdated;
    }

    public function getPercentComplete()
    {
        return $this->percentComplete;
    }

    public function setPercentComplete($percentComplete)
    {
        $this->percentComplete = $percentComplete;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "description" => $this->getDescription(),
            "sendTo" => $this->getSendTo(),
            "kind" => $this->getKind(),
            "roles" => $this->getRoles(),
            "locationId" => $this->getLocationId(),
            "language" => $this->getLanguage(),
            "participationStatus" => $this->getParticipationStatus(),
            "participationComment" => $this->getParticipationComment(),
            "expectReply" => $this->getExpectReply(),
            "scheduleAgent" => $this->getScheduleAgent(),
            "scheduleForceSend" => $this->getScheduleForceSend(),
            "scheduleSequence" => $this->getScheduleSequence(),
            "scheduleStatus" => $this->getScheduleStatus(),
            "scheduleUpdated" => $this->getScheduleUpdated(),
            "invitedBy" => $this->getInvitedBy(),
            "delegatedTo" => $this->getDelegatedTo(),
            "delegatedFrom" => $this->getDelegatedFrom(),
            "memberOf" => $this->getMemberOf(),
            "links" => $this->getLinks(),
            "progress" => $this->getProgress(),
            "progressUpdated" => $this->getProgressUpdated(),
            "percentComplete" => $this->getPercentComplete()
        ];
    }
}
