<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;
use OpenXPort\Jmap\Calendar\PatchObject;

/**
 * Class which represents a JMAP Calendar Event (according to JMAP Calendars draft-ietf-jmap-calendars-26)
 *
 */
class CalendarEvent extends JSCalendarDataType implements JsonSerializable
{
    private $id;
    private $baseEventId;
    private $calendarIds;
    private $isDraft;
    private $isOrigin;
    private $utcStart;
    private $utcEnd;
    private $type;
    private $uid;
    private $relatedTo;
    private $prodId;
    private $created;
    private $updated;
    private $sequence;
    private $method;
    private $title;
    private $description;
    private $descriptionContentType;
    private $start;
    private $duration;
    private $timeZone;
    private $showWithoutTime;
    private $status;
    private $privacy;
    private $freeBusyStatus;
    private $priority;
    private $locations;
    private $virtualLocations;
    private $recurrenceRules;
    private $recurrenceOverrides;
    private $excluded;
    private $recurrenceId;
    private $participants;
    private $replyTo;
    private $sentBy;
    private $mayInviteSelf;
    private $mayInviteOthers;
    private $hideAttendees;
    private $useDefaultAlerts;
    private $alerts;
    private $links;
    private $locale;
    private $keywords;
    private $color;
    private $customProperties;

    public function __construct()
    {
        $this->setType('Event');
    }

    /**
     * Get the event ID
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the event ID
     *
     * @param string|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the base event ID for recurring events
     *
     * @return string|null
     */
    public function getBaseEventId()
    {
        return $this->baseEventId;
    }

    /**
     * Set the base event ID for recurring events
     *
     * @param string|null $baseEventId
     */
    public function setBaseEventId($baseEventId)
    {
        $this->baseEventId = $baseEventId;
    }

    /**
     * Get the calendar IDs this event belongs to
     *
     * @return array<string,bool>|null
     */
    public function getCalendarIds()
    {
        return $this->calendarIds;
    }

    /**
     * Set the calendar IDs this event belongs to
     *
     * @param array<string,bool>|null $calendarIds
     */
    public function setCalendarIds($calendarIds)
    {
        $this->calendarIds = $calendarIds;
    }

    /**
     * Get whether this is a draft event
     *
     * @return bool|null
     */
    public function getIsDraft()
    {
        return $this->isDraft;
    }

    /**
     * Set whether this is a draft event
     *
     * @param bool|null $isDraft
     */
    public function setIsDraft($isDraft)
    {
        $this->isDraft = $isDraft;
    }

    /**
     * Get whether this is the origin of the event
     *
     * @return bool|null
     */
    public function getIsOrigin()
    {
        return $this->isOrigin;
    }

    /**
     * Set whether this is the origin of the event
     *
     * @param bool|null $isOrigin
     */
    public function setIsOrigin($isOrigin)
    {
        $this->isOrigin = $isOrigin;
    }

    /**
     * Get the UTC start time
     *
     * @return string|null
     */
    public function getUtcStart()
    {
        return $this->utcStart;
    }

    /**
     * Set the UTC start time
     *
     * @param string|null $utcStart
     */
    public function setUtcStart($utcStart)
    {
        $this->utcStart = $utcStart;
    }

    /**
     * Get the UTC end time
     *
     * @return string|null
     */
    public function getUtcEnd()
    {
        return $this->utcEnd;
    }

    /**
     * Set the UTC end time
     *
     * @param string|null $utcEnd
     */
    public function setUtcEnd($utcEnd)
    {
        $this->utcEnd = $utcEnd;
    }

    /**
     * Get the event type
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the event type
     *
     * @param string|null $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get the unique identifier
     *
     * @return string|null
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the unique identifier
     *
     * @param string|null $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Get related events
     *
     * @return array<string,Relation>|null
     */
    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    /**
     * Set related events
     *
     * @param array<string,Relation>|null $relatedTo
     */
    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    /**
     * Get the product ID
     *
     * @return string|null
     */
    public function getProdId()
    {
        return $this->prodId;
    }

    /**
     * Set the product ID
     *
     * @param string|null $prodId
     */
    public function setProdId($prodId)
    {
        $this->prodId = $prodId;
    }

    /**
     * Get the creation timestamp
     *
     * @return string|null
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the creation timestamp
     *
     * @param string|null $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get the last update timestamp
     *
     * @return string|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the last update timestamp
     *
     * @param string|null $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get the sequence number
     *
     * @return int|null
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Set the sequence number
     *
     * @param int|null $sequence
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    /**
     * Get the iTIP method
     *
     * @return string|null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the iTIP method
     *
     * @param string|null $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Get the event title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the event title
     *
     * @param string|null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the event description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the event description
     *
     * @param string|null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get the description content type
     *
     * @return string|null
     */
    public function getDescriptionContentType()
    {
        return $this->descriptionContentType;
    }

    /**
     * Set the description content type
     *
     * @param string|null $descriptionContentType
     */
    public function setDescriptionContentType($descriptionContentType)
    {
        $this->descriptionContentType = $descriptionContentType;
    }

    /**
     * Get the start date/time
     *
     * @return string|null
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set the start date/time
     *
     * @param string|null $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * Get the duration
     *
     * @return string|null
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the duration
     *
     * @param string|null $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get the time zone
     *
     * @return string|null
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Set the time zone
     *
     * @param string|null $timeZone
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    /**
     * Get whether to show without time
     *
     * @return bool|null
     */
    public function getShowWithoutTime()
    {
        return $this->showWithoutTime;
    }

    /**
     * Set whether to show without time
     *
     * @param bool|null $showWithoutTime
     */
    public function setShowWithoutTime($showWithoutTime)
    {
        $this->showWithoutTime = $showWithoutTime;
    }

    /**
     * Get the event status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the event status
     *
     * @param string|null $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get the privacy setting
     *
     * @return string|null
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }

    /**
     * Set the privacy setting
     *
     * @param string|null $privacy
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }

    /**
     * Get the free/busy status
     *
     * @return string|null
     */
    public function getFreeBusyStatus()
    {
        return $this->freeBusyStatus;
    }

    /**
     * Set the free/busy status
     *
     * @param string|null $freeBusyStatus
     */
    public function setFreeBusyStatus($freeBusyStatus)
    {
        $this->freeBusyStatus = $freeBusyStatus;
    }

    /**
     * Get the priority
     *
     * @return int|null
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the priority
     *
     * @param int|null $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Get the locations
     *
     * @return array<string,Location>|null
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Set the locations
     *
     * @param array<string,Location>|null $locations
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
    }

    /**
     * Get the virtual locations
     *
     * @return array<string,VirtualLocation>|null
     */
    public function getVirtualLocations()
    {
        return $this->virtualLocations;
    }

    /**
     * Set the virtual locations
     *
     * @param array<string,VirtualLocation>|null $virtualLocations
     */
    public function setVirtualLocations($virtualLocations)
    {
        $this->virtualLocations = $virtualLocations;
    }

    /**
     * Get the recurrence rules
     *
     * @return RecurrenceRule[]|null
     */
    public function getRecurrenceRules()
    {
        return $this->recurrenceRules;
    }

    /**
     * Set the recurrence rules
     *
     * @param RecurrenceRule[]|null $recurrenceRules
     */
    public function setRecurrenceRules($recurrenceRules)
    {
        $this->recurrenceRules = $recurrenceRules;
    }

    /**
     * Get the recurrence overrides
     *
     * recurrenceOverrides: LocalDateTime[PatchObject].
     * Keys are recurrence-ids (e.g. "2025-03-05T09:00:00"), values are
     * PatchObject instances whose keys are JSCalendar patch paths.
     *
     * @return array<string,PatchObject>|null
     */
    public function getRecurrenceOverrides()
    {
        return $this->recurrenceOverrides;
    }

    /**
     * Set the recurrence overrides
     *
     * @param array<string,PatchObject>|null $recurrenceOverrides
     */
    public function setRecurrenceOverrides($recurrenceOverrides)
    {
        $this->recurrenceOverrides = $recurrenceOverrides;
    }

    /**
     * Get whether this instance is excluded
     *
     * @return bool|null
     */
    public function getExcluded()
    {
        return $this->excluded;
    }

    /**
     * Set whether this instance is excluded
     *
     * @param bool|null $excluded
     */
    public function setExcluded($excluded)
    {
        $this->excluded = $excluded;
    }

    /**
     * Get the recurrence ID
     *
     * @return string|null
     */
    public function getRecurrenceId()
    {
        return $this->recurrenceId;
    }

    /**
     * Set the recurrence ID
     *
     * @param string|null $recurrenceId
     */
    public function setRecurrenceId($recurrenceId)
    {
        $this->recurrenceId = $recurrenceId;
    }

    /**
     * Get the participants
     *
     * @return array<string,Participant>|null
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set the participants
     *
     * @param array<string,Participant>|null $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    /**
     * Get the reply-to addresses
     *
     * @return array<string,string>|null
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set the reply-to addresses
     *
     * @param array<string,string>|null $replyTo
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * Get the sent-by address
     *
     * @return string|null
     */
    public function getSentBy()
    {
        return $this->sentBy;
    }

    /**
     * Set the sent-by address
     *
     * @param string|null $sentBy
     */
    public function setSentBy($sentBy)
    {
        $this->sentBy = $sentBy;
    }

    /**
     * Get whether participant may invite self
     *
     * @return bool|null
     */
    public function getMayInviteSelf()
    {
        return $this->mayInviteSelf;
    }

    /**
     * Set whether participant may invite self
     *
     * @param bool|null $mayInviteSelf
     */
    public function setMayInviteSelf($mayInviteSelf)
    {
        $this->mayInviteSelf = $mayInviteSelf;
    }

    /**
     * Get whether participant may invite others
     *
     * @return bool|null
     */
    public function getMayInviteOthers()
    {
        return $this->mayInviteOthers;
    }

    /**
     * Set whether participant may invite others
     *
     * @param bool|null $mayInviteOthers
     */
    public function setMayInviteOthers($mayInviteOthers)
    {
        $this->mayInviteOthers = $mayInviteOthers;
    }

    /**
     * Get whether to hide attendees
     *
     * @return bool|null
     */
    public function getHideAttendees()
    {
        return $this->hideAttendees;
    }

    /**
     * Set whether to hide attendees
     *
     * @param bool|null $hideAttendees
     */
    public function setHideAttendees($hideAttendees)
    {
        $this->hideAttendees = $hideAttendees;
    }

    /**
     * Get whether to use default alerts
     *
     * @return bool|null
     */
    public function getUseDefaultAlerts()
    {
        return $this->useDefaultAlerts;
    }

    /**
     * Set whether to use default alerts
     *
     * @param bool|null $useDefaultAlerts
     */
    public function setUseDefaultAlerts($useDefaultAlerts)
    {
        $this->useDefaultAlerts = $useDefaultAlerts;
    }

    /**
     * Get the alerts
     *
     * @return array<string,Alert>|null
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * Set the alerts
     *
     * @param array<string,Alert>|null $alerts
     */
    public function setAlerts($alerts)
    {
        $this->alerts = $alerts;
    }

    /**
     * Get the links
     *
     * @return array<string,Link>|null
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set the links
     *
     * @param array<string,Link>|null $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * Get the locale
     *
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the locale
     *
     * @param string|null $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get the keywords
     *
     * @return array<string,bool>|null
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the keywords
     *
     * @param array<string,bool>|null $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Get the color
     *
     * @return string|null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the color
     *
     * @param string|null $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Add a custom property
     *
     * @param string $propertyName
     * @param mixed $value
     */
    public function addCustomProperty($propertyName, $value)
    {
        $this->customProperties[$propertyName] = $value;
    }

    /**
     * Get all custom properties
     *
     * @return array<string,mixed>|null
     */
    public function getCustomProperties()
    {
        return $this->customProperties;
    }

    /**
     * Serialize the CalendarEvent to JSON
     *
     * @return object
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "id" => $this->getId(),
            "baseEventId" => $this->getBaseEventId(),
            "calendarIds" => $this->getCalendarIds(),
            "isDraft" => $this->getIsDraft(),
            "isOrigin" => $this->getIsOrigin(),
            "utcStart" => $this->getUtcStart(),
            "utcEnd" => $this->getUtcEnd(),
            "@type" => $this->getType(),
            "uid" => $this->getUid(),
            "relatedTo" => $this->getRelatedTo(),
            "prodId" => $this->getProdId(),
            "created" => $this->getCreated(),
            "updated" => $this->getUpdated(),
            "sequence" => $this->getSequence(),
            "method" => $this->getMethod(),
            "title" => $this->getTitle(),
            "description" => $this->getDescription(),
            "descriptionContentType" => $this->getDescriptionContentType(),
            "start" => $this->getStart(),
            "duration" => $this->getDuration(),
            "timeZone" => $this->getTimeZone(),
            "showWithoutTime" => $this->getShowWithoutTime(),
            "status" => $this->getStatus(),
            "privacy" => $this->getPrivacy(),
            "freeBusyStatus" => $this->getFreeBusyStatus(),
            "priority" => $this->getPriority(),
            "locations" => $this->getLocations(),
            "virtualLocations" => $this->getVirtualLocations(),
            "recurrenceRules" => $this->getRecurrenceRules(),
            "recurrenceOverrides" => $this->getRecurrenceOverrides(),
            "excluded" => $this->getExcluded(),
            "recurrenceId" => $this->getRecurrenceId(),
            "participants" => $this->getParticipants(),
            "replyTo" => $this->getReplyTo(),
            "sentBy" => $this->getSentBy(),
            "mayInviteSelf" => $this->getMayInviteSelf(),
            "mayInviteOthers" => $this->getMayInviteOthers(),
            "hideAttendees" => $this->getHideAttendees(),
            "useDefaultAlerts" => $this->getUseDefaultAlerts(),
            "alerts" => $this->getAlerts(),
            "links" => $this->getLinks(),
            "locale" => $this->getLocale(),
            "keywords" => $this->getKeywords(),
            "color" => $this->getColor()
        ];

        if (AdapterUtil::isSetNotNullAndNotEmpty($this->getCustomProperties())) {
            foreach ($this->getCustomProperties() as $name => $value) {
                $objectProperties[$name] = $value;
            }
        }

        return (object) array_filter($objectProperties, function ($val) {
            return !is_null($val);
        });
    }

    /**
     * Parses a CalendarEvent object from the given JSON representation.
     *
     * @param mixed $json String/Array containing a calendar event in the JSCalendar format.
     *
     * @return CalendarEvent CalendarEvent object containing any properties that can be
     * parsed from the given JSON string/array.
     */
    public static function fromJson($json)
    {
        // Array of every variable that has a custom object type.
        $objectVariables = [
            "locations" => "Location",
            "virtualLocations" => "VirtualLocation",
            "links" => "Link",
            "recurrenceRules" => "RecurrenceRule",
            "participants" => "Participant",
            "alerts" => "Alert",
            "relatedTo" => "Relation"
        ];

        if (is_string($json)) {
            $json = json_decode($json);
        }

        if (is_array($json)) {
            return parent::fromJsonArray($json);
        }

        $classInstance = new self();

        foreach ($json as $key => $value) {
            // The "@type" property is defined as "type" in the custom classes.
            if ($key == "@type") {
                $key = "type";
            }

            if (!property_exists($classInstance, $key)) {
                $logger = Logger::getInstance();
                $logger->warning("File contains property not existing in " . self::class . ": $key");

                $classInstance->addCustomProperty($key, $value);
                continue;
            }

            // Since all of the properties are private, using this will allow access to the setter
            // functions of any given property.
            // Caution! In order for this to work, every setter method needs to match the property
            // name. So for a var fooBar, the setter needs to be named setFooBar($fooBar).
            $setPropertyMethod = "set" . ucfirst($key);

            // As custom properties are already added to the object this will only happen if there is a
            // mistake in the class as in a missing or misspelled setter.
            if (!method_exists($classInstance, $setPropertyMethod)) {
                $logger = Logger::getInstance();
                $logger->warning(
                    self::class . " is missing a setter for $key. "
                    . "\"$key\": \"$value\" added to custom properties instead."
                );

                $classInstance->addCustomProperty($key, $value);
                continue;
            }

            // Access the setter method of the given property. If the property is an Object in the JSCalendar
            // spec itself, call that class' fromJson method to parse the JSON object accordingly.
            if (array_key_exists($key, $objectVariables)) {
                $className = "OpenXPort\Jmap\Calendar\\$objectVariables[$key]";

                // Special handling for recurrenceRules which is an array of RecurrenceRule objects
                if ($key == "recurrenceRules" && is_array($value)) {
                    $rules = [];
                    foreach ($value as $ruleJson) {
                        $rules[] = $className::fromJson($ruleJson);
                    }
                    $classInstance->{"$setPropertyMethod"}($rules);
                } else {
                    $classInstance->{"$setPropertyMethod"}(
                        $className::fromJson($value)
                    );
                }
            } elseif ($key == "recurrenceOverrides") {
                // In the JSCalendar RFC, recurrenceOverrides are Instances of PatchObjects.
                $recurrenceOverrides = [];

                foreach ($value as $id => $override) {
                    $patchObject = PatchObject::fromJson($override);

                    $recurrenceOverrides[$id] = $patchObject;
                }
                $classInstance->setRecurrenceOverrides($recurrenceOverrides);
            } else {
                // These properties are saved as associative arrays, so doing this prevents them from being
                // saved as stdClass objects through json_decode().
                if (
                    $key == "keywords" || $key == "replyTo" ||
                    $key == "calendarIds" || $key == "customProperties"
                ) {
                    $value = (array) $value;
                }

                $classInstance->{"$setPropertyMethod"}($value);
            }
        }

        return $classInstance;
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        if ($this->locations) {
            foreach ($this->locations as $id => $loc) {
                $loc->sanitizeFreeText();
            }
        }
        if ($this->virtualLocations) {
            foreach ($this->virtualLocations as $id => $vloc) {
                $vloc->sanitizeFreeText();
            }
        }
        if ($this->links) {
            foreach ($this->links as $id => $link) {
                $link->sanitizeFreeText();
            }
        }
        if ($this->alerts) {
            foreach ($this->alerts as $id => $alert) {
                $alert->sanitizeFreeText();
            }
        }
        if ($this->participants) {
            foreach ($this->participants as $id => $participant) {
                $participant->sanitizeFreeText();
            }
        }
        if ($this->recurrenceOverrides) {
            foreach ($this->recurrenceOverrides as $id => $override) {
                $override->sanitizeFreeText();
            }
        }

        $this->title = AdapterUtil::reencode($this->title);
        $this->description = AdapterUtil::reencode($this->description);
        $this->keywords = AdapterUtil::reencode($this->keywords);
    }
}
