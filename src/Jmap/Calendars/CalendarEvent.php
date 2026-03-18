<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;

/**
 * CalendarEvent object for JMAP Calendars (draft-ietf-jmap-calendars-26).
 *
 * This class exposes the JMAP wrapper properties (id, baseEventId,
 * calendarIds, isDraft, isOrigin, utcStart, utcEnd) as well as the
 * JSCalendar Event properties you support (start, title, uid, etc.).
 */
class CalendarEvent extends JSCalendarDataType implements JsonSerializable
{
    /** @var string|null */
    private $id;

    /** @var string|null */
    private $baseEventId;

    /** @var array<string,bool>|null */
    private $calendarIds;

    /** @var string|null */
    private $type;

    /** @var bool|null */
    private $isDraft;

    /** @var bool|null */
    private $isOrigin;

    /** @var string|null */
    private $start;

    /** @var string|null */
    private $utcStart;

    /** @var string|null */
    private $utcEnd;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $uid;

    /** @var string|null */
    private $prodId;

    /** @var string|null */
    private $status;

    /** @var string|null */
    private $created;

    /** @var string|null */
    private $updated;

    /** @var string|null */
    private $duration;

    /** @var bool|null */
    private $showWithoutTime;

    /** @var array<string,Alert>|null */
    private $alerts;

    /** @var array<string,Participant>|null */
    private $participants;

    /** @var string|null */
    private $timeZone;

    /** @var int|null */
    private $sequence;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $privacy;

    /** @var array<string,bool>|null */
    private $keywords;

    /** @var RecurrenceRule[]|null */
    private $recurrenceRules;

    /**
     * recurrenceOverrides: LocalDateTime[PatchObject].
     *
     * Keys are recurrence-ids (e.g. "2025-03-05T09:00:00"), values are
     * PatchObject instances whose keys are JSCalendar patch paths, e.g.:
     *  - "start" => "2025-03-05T10:00:00"
     *  - "participants/xxx/participationStatus" => "declined"
     *
     * @var array<string,PatchObject>|null
     */
    private $recurrenceOverrides;

    /** @var array<string,Location>|null */
    private $locations;

    /** @var string|null */
    private $freeBusyStatus;

    /** @var bool|null */
    private $useDefaultAlerts;

    /** @var bool|null */
    private $mayInviteSelf;

    /** @var bool|null */
    private $mayInviteOthers;

    /** @var bool|null */
    private $hideAttendees;

    /** @var array<string,Relation>|null */
    private $relatedTo;

    /** @var string|null */
    private $method;

    /** @var array<string,VirtualLocation>|null */
    private $virtualLocations;

    /** @var int|null */
    private $priority;

    /** @var string|null */
    private $color;

    /** @var array<string,Link>|null */
    private $links;

    /** @var string|null */
    private $locale;

    /** @var array<string,string>|null */
    private $replyTo;

    /** @var string|null */
    private $sentBy;

    /** @var bool|null */
    private $excluded;

    /** @var string|null */
    private $recurrenceId;

    /** @var array<string,mixed>|null */
    private $customProperties;


        /**
     * Construct a CalendarEvent with all properties optional.
     *
     * All parameters map 1:1 to the corresponding properties.
     * `$type` defaults to "Event" if not provided.
     *
     * @param string|null                 $id
     * @param string|null                 $baseEventId
     * @param array<string,bool>|null     $calendarIds
     * @param string|null                 $type
     * @param bool|null                   $isDraft
     * @param bool|null                   $isOrigin
     * @param string|null                 $start
     * @param string|null                 $utcStart
     * @param string|null                 $utcEnd
     * @param string|null                 $title
     * @param string|null                 $uid
     * @param string|null                 $prodId
     * @param string|null                 $status
     * @param string|null                 $created
     * @param string|null                 $updated
     * @param string|null                 $duration
     * @param bool|null                   $showWithoutTime
     * @param array<string,Alert>|null    $alerts
     * @param array<string,Participant>|null $participants
     * @param string|null                 $timeZone
     * @param int|null                    $sequence
     * @param string|null                 $description
     * @param string|null                 $privacy
     * @param array<string,bool>|null     $keywords
     * @param RecurrenceRule[]|null       $recurrenceRules
     * @param array<string,PatchObject>|null $recurrenceOverrides
     * @param array<string,Location>|null $locations
     * @param string|null                 $freeBusyStatus
     * @param bool|null                   $useDefaultAlerts
     * @param bool|null                   $mayInviteSelf
     * @param bool|null                   $mayInviteOthers
     * @param bool|null                   $hideAttendees
     * @param array<string,Relation>|null $relatedTo
     * @param string|null                 $method
     * @param array<string,VirtualLocation>|null $virtualLocations
     * @param int|null                    $priority
     * @param string|null                 $color
     * @param array<string,Link>|null     $links
     * @param string|null                 $locale
     * @param array<string,string>|null   $replyTo
     * @param string|null                 $sentBy
     * @param bool|null                   $excluded
     * @param string|null                 $recurrenceId
     * @param array<string,mixed>|null    $customProperties
     */
    public function __construct(
        $id = null,
        $baseEventId = null,
        $calendarIds = null,
        $type = 'Event',
        $isDraft = null,
        $isOrigin = null,
        $start = null,
        $utcStart = null,
        $utcEnd = null,
        $title = null,
        $uid = null,
        $prodId = null,
        $status = null,
        $created = null,
        $updated = null,
        $duration = null,
        $showWithoutTime = null,
        $alerts = null,
        $participants = null,
        $timeZone = null,
        $sequence = null,
        $description = null,
        $privacy = null,
        $keywords = null,
        $recurrenceRules = null,
        $recurrenceOverrides = null,
        $locations = null,
        $freeBusyStatus = null,
        $useDefaultAlerts = null,
        $mayInviteSelf = null,
        $mayInviteOthers = null,
        $hideAttendees = null,
        $relatedTo = null,
        $method = null,
        $virtualLocations = null,
        $priority = null,
        $color = null,
        $links = null,
        $locale = null,
        $replyTo = null,
        $sentBy = null,
        $excluded = null,
        $recurrenceId = null,
        $customProperties = null
    ) {
        $this->id = $id;
        $this->baseEventId = $baseEventId;
        $this->calendarIds = $calendarIds;
        $this->type = $type;
        $this->isDraft = $isDraft;
        $this->isOrigin = $isOrigin;
        $this->start = $start;
        $this->utcStart = $utcStart;
        $this->utcEnd = $utcEnd;
        $this->title = $title;
        $this->uid = $uid;
        $this->prodId = $prodId;
        $this->status = $status;
        $this->created = $created;
        $this->updated = $updated;
        $this->duration = $duration;
        $this->showWithoutTime = $showWithoutTime;
        $this->alerts = $alerts;
        $this->participants = $participants;
        $this->timeZone = $timeZone;
        $this->sequence = $sequence;
        $this->description = $description;
        $this->privacy = $privacy;
        $this->keywords = $keywords;
        $this->recurrenceRules = $recurrenceRules;
        $this->recurrenceOverrides = $recurrenceOverrides;
        $this->locations = $locations;
        $this->freeBusyStatus = $freeBusyStatus;
        $this->useDefaultAlerts = $useDefaultAlerts;
        $this->mayInviteSelf = $mayInviteSelf;
        $this->mayInviteOthers = $mayInviteOthers;
        $this->hideAttendees = $hideAttendees;
        $this->relatedTo = $relatedTo;
        $this->method = $method;
        $this->virtualLocations = $virtualLocations;
        $this->priority = $priority;
        $this->color = $color;
        $this->links = $links;
        $this->locale = $locale;
        $this->replyTo = $replyTo;
        $this->sentBy = $sentBy;
        $this->excluded = $excluded;
        $this->recurrenceId = $recurrenceId;
        $this->customProperties = $customProperties;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getBaseEventId()
    {
        return $this->baseEventId;
    }

    public function setBaseEventId($baseEventId)
    {
        $this->baseEventId = $baseEventId;
    }

    /**
     * @return array<string,bool>|null
     */
    public function getCalendarIds()
    {
        return $this->calendarIds;
    }

    /**
     * @param array<string,bool>|null $calendarIds
     */
    public function setCalendarIds($calendarIds)
    {
        $this->calendarIds = $calendarIds;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getIsDraft()
    {
        return $this->isDraft;
    }

    public function setIsDraft($isDraft)
    {
        $this->isDraft = $isDraft;
    }

    public function getIsOrigin()
    {
        return $this->isOrigin;
    }

    public function setIsOrigin($isOrigin)
    {
        $this->isOrigin = $isOrigin;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getUtcStart()
    {
        return $this->utcStart;
    }

    public function setUtcStart($utcStart)
    {
        $this->utcStart = $utcStart;
    }

    public function getUtcEnd()
    {
        return $this->utcEnd;
    }

    public function setUtcEnd($utcEnd)
    {
        $this->utcEnd = $utcEnd;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getProdId()
    {
        return $this->prodId;
    }

    public function setProdId($prodId)
    {
        $this->prodId = $prodId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getShowWithoutTime()
    {
        return $this->showWithoutTime;
    }

    public function setShowWithoutTime($showWithoutTime)
    {
        $this->showWithoutTime = $showWithoutTime;
    }

    /**
     * @return array<string,Alert>|null
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @param array<string,Alert>|null $alerts
     */
    public function setAlerts($alerts)
    {
        $this->alerts = $alerts;
    }

    /**
     * @return array<string,Participant>|null
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param array<string,Participant>|null $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrivacy()
    {
        return $this->privacy;
    }

    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }

    /**
     * @return array<string,bool>|null
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array<string,bool>|null $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return RecurrenceRule[]|null
     */
    public function getRecurrenceRules()
    {
        return $this->recurrenceRules;
    }

    /**
     * @param RecurrenceRule[]|null $recurrenceRules
     */
    public function setRecurrenceRules($recurrenceRules)
    {
        $this->recurrenceRules = $recurrenceRules;
    }

    /**
     * @return array<string,PatchObject>|null
     */
    public function getRecurrenceOverrides()
    {
        return $this->recurrenceOverrides;
    }

    /**
     * @param array<string,PatchObject>|null $recurrenceOverrides
     */
    public function setRecurrenceOverrides($recurrenceOverrides)
    {
        $this->recurrenceOverrides = $recurrenceOverrides;
    }

    /**
     * @return array<string,Location>|null
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param array<string,Location>|null $locations
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
    }

    public function getFreeBusyStatus()
    {
        return $this->freeBusyStatus;
    }

    public function setFreeBusyStatus($freeBusyStatus)
    {
        $this->freeBusyStatus = $freeBusyStatus;
    }

    public function getUseDefaultAlerts()
    {
        return $this->useDefaultAlerts;
    }

    public function setUseDefaultAlerts($useDefaultAlerts)
    {
        $this->useDefaultAlerts = $useDefaultAlerts;
    }

    public function getMayInviteSelf()
    {
        return $this->mayInviteSelf;
    }

    public function setMayInviteSelf($mayInviteSelf)
    {
        $this->mayInviteSelf = $mayInviteSelf;
    }

    public function getMayInviteOthers()
    {
        return $this->mayInviteOthers;
    }

    public function setMayInviteOthers($mayInviteOthers)
    {
        $this->mayInviteOthers = $mayInviteOthers;
    }

    public function getHideAttendees()
    {
        return $this->hideAttendees;
    }

    public function setHideAttendees($hideAttendees)
    {
        $this->hideAttendees = $hideAttendees;
    }

    /**
     * @return array<string,Relation>|null
     */
    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    /**
     * @param array<string,Relation>|null $relatedTo
     */
    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return array<string,VirtualLocation>|null
     */
    public function getVirtualLocations()
    {
        return $this->virtualLocations;
    }

    /**
     * @param array<string,VirtualLocation>|null $virtualLocations
     */
    public function setVirtualLocations($virtualLocations)
    {
        $this->virtualLocations = $virtualLocations;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return array<string,Link>|null
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array<string,Link>|null $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return array<string,string>|null
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param array<string,string>|null $replyTo
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    public function getSentBy()
    {
        return $this->sentBy;
    }

    public function setSentBy($sentBy)
    {
        $this->sentBy = $sentBy;
    }

    public function getExcluded()
    {
        return $this->excluded;
    }

    public function setExcluded($excluded)
    {
        $this->excluded = $excluded;
    }

    public function getRecurrenceId()
    {
        return $this->recurrenceId;
    }

    public function setRecurrenceId($recurrenceId)
    {
        $this->recurrenceId = $recurrenceId;
    }

    public function addCustomProperty($propertyName, $value)
    {
        $this->customProperties[$propertyName] = $value;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function getCustomProperties()
    {
        return $this->customProperties;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "id" => $this->getId(),
            "baseEventId" => $this->getBaseEventId(),
            "@type" => $this->getType(),
            "isDraft" => $this->getIsDraft(),
            "isOrigin" => $this->getIsOrigin(),
            "start" => $this->getStart(),
            "utcStart" => $this->getUtcStart(),
            "utcEnd" => $this->getUtcEnd(),
            "title" => $this->getTitle(),
            "uid" => $this->getUid(),
            "prodId" => $this->getProdId(),
            "status" => $this->getStatus(),
            "created" => $this->getCreated(),
            "updated" => $this->getUpdated(),
            "duration" => $this->getDuration(),
            "showWithoutTime" => $this->getShowWithoutTime(),
            "alerts" => $this->getAlerts(),
            "participants" => $this->getParticipants(),
            "timeZone" => $this->getTimeZone(),
            "sequence" => $this->getSequence(),
            "description" => $this->getDescription(),
            "privacy" => $this->getPrivacy(),
            "keywords" => $this->getKeywords(),
            "recurrenceRules" => $this->getRecurrenceRules(),
            "locations" => $this->getLocations(),
            "freeBusyStatus" => $this->getFreeBusyStatus(),
            "calendarIds" => $this->getCalendarIds(),
            "recurrenceOverrides" => $this->getRecurrenceOverrides(),
            "useDefaultAlerts" => $this->getUseDefaultAlerts(),
            "mayInviteSelf" => $this->getMayInviteSelf(),
            "mayInviteOthers" => $this->getMayInviteOthers(),
            "hideAttendees" => $this->getHideAttendees(),
            "relatedTo" => $this->getRelatedTo(),
            "method" => $this->getMethod(),
            "virtualLocations" => $this->getVirtualLocations(),
            "priority" => $this->getPriority(),
            "color" => $this->getColor(),
            "links" => $this->getLinks(),
            "locale" => $this->getLocale(),
            "replyTo" => $this->getReplyTo(),
            "sentBy" => $this->getSentBy(),
            "excluded" => $this->getExcluded(),
            "recurrenceId" => $this->getRecurrenceId(),
        ];

        if ($this->customProperties !== null) {
            foreach ($this->customProperties as $name => $value) {
                $objectProperties[$name] = $value;
            }
        }

        return (object) array_filter($objectProperties, static function ($val) {
            return $val !== null;
        });
    }

    /**
     * Parses a CalendarEvent object from the given JSON representation.
     *
     * @param mixed $json String/Array/object containing a calendar event.
     *
     * @return CalendarEvent
     */
    public static function fromJson($json)
    {
        $objectVariables = [
            "alerts" => "Alert",
            "participants" => "Participant",
            "locations" => "Location",
            "recurrenceRules" => "RecurrenceRule",
            "virtualLocations" => "VirtualLocation",
            "links" => "Link",
            "relatedTo" => "Relation",
        ];

        if (is_string($json)) {
            $json = json_decode($json);
        }

        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        $classInstance = new self();
        $logger = Logger::getInstance();

        foreach ($json as $key => $value) {
            if ($key === "@type") {
                $key = "type";
            }

            if (!property_exists($classInstance, $key)) {
                $logger->warning("File contains property not existing in " . self::class . ": $key");
                $classInstance->addCustomProperty($key, $value);
                continue;
            }

            $setPropertyMethod = "set" . ucfirst($key);

            if (!method_exists($classInstance, $setPropertyMethod)) {
                $logger->warning(
                    self::class . " is missing a setter for $key. "
                    . "\"$key\": \"$value\" added to custom properties instead."
                );
                $classInstance->addCustomProperty($key, $value);
                continue;
            }

            if (array_key_exists($key, $objectVariables)) {
                $className = "OpenXPort\\Jmap\\Calendar\\{$objectVariables[$key]}";
                if ($key === "recurrenceRules" && is_array($value)) {
                    $rules = [];
                    foreach ($value as $ruleJson) {
                        $rules[] = $className::fromJson($ruleJson);
                    }
                    $classInstance->{$setPropertyMethod}($rules);
                } else {
                    $classInstance->{$setPropertyMethod}(
                        $className::fromJson($value)
                    );
                }
            } elseif ($key === "recurrenceOverrides") {
                $overrides = [];
                foreach ($value as $id => $override) {
                    $overrides[$id] = PatchObject::fromJson($override);
                }
                $classInstance->setRecurrenceOverrides($overrides);
            } else {
                if ($key === "calendarIds") {
                    $value = (array) $value;
                }
                $classInstance->{$setPropertyMethod}($value);
            }
        }

        return $classInstance;
    }

    public function sanitizeFreeText()
    {
        if ($this->locations) {
            foreach ($this->locations as $loc) {
                if (method_exists($loc, 'sanitizeFreeText')) {
                    $loc->sanitizeFreeText();
                }
            }
        }
        if ($this->virtualLocations) {
            foreach ($this->virtualLocations as $vloc) {
                if (method_exists($vloc, 'sanitizeFreeText')) {
                    $vloc->sanitizeFreeText();
                }
            }
        }
        if ($this->alerts) {
            foreach ($this->alerts as $alert) {
                if (method_exists($alert, 'sanitizeFreeText')) {
                    $alert->sanitizeFreeText();
                }
            }
        }
        if ($this->participants) {
            foreach ($this->participants as $participant) {
                if (method_exists($participant, 'sanitizeFreeText')) {
                    $participant->sanitizeFreeText();
                }
            }
        }
        if ($this->links) {
            foreach ($this->links as $link) {
                if (method_exists($link, 'sanitizeFreeText')) {
                    $link->sanitizeFreeText();
                }
            }
        }

        $this->title = AdapterUtil::reencode($this->title);
        $this->description = AdapterUtil::reencode($this->description);
    }
}
