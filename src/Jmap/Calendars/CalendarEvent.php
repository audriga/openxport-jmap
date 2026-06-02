<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;

/**
 * Class which represents a JMAP Calendar Event (according to JSCalendar)
 */
class CalendarEvent extends JSCalendarDataType implements JsonSerializable
{
    private $id;
    private $calendarId;
    private $participantId;
    private $start;
    private $duration;
    private $status;
    private $type; // this is serialized as "@type" in JSON
    private $uid;
    private $relatedTo;
    private $prodId;
    private $created;
    private $updated;
    private $sequence;
    private $title;
    private $description;
    private $descriptionContentType;
    private $showWithoutTime;
    private $locations;
    private $virtualLocations;
    private $links;
    private $locale;
    private $keywords;
    private $recurrenceRule;
    private $recurrenceRules;
    private $recurrenceOverrides;
    private $excluded;
    private $priority;
    private $freeBusyStatus;
    private $privacy;
    private $replyTo;
    private $participants;
    private $useDefaultAlerts;
    private $alerts;
    private $timeZone;
    private $color;

    private $customProperties;

    private $baseEventId;
    private $calendarIds;
    private $isDraft;
    private $isOrigin;
    private $utcStart;
    private $utcEnd;
    private $method;
    private $vLocations;
    private $coordinates;
    private $recurrenceId;
    private $sentBy;
    private $mayInviteSelf;
    private $mayInviteOthers;
    private $hideAttendees;
    private $url;
    private $requestStatus;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCalendarId()
    {
        return $this->calendarId;
    }

    public function setCalendarId($calendarId)
    {
        $this->calendarId = $calendarId;
    }

    public function getParticipantId()
    {
        return $this->participantId;
    }

    public function setParticipantId($participantId)
    {
        $this->participantId = $participantId;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function getProdId()
    {
        return $this->prodId;
    }

    public function setProdId($prodId)
    {
        $this->prodId = $prodId;
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

    public function getSequence()
    {
        return $this->sequence;
    }

    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescriptionContentType()
    {
        return $this->descriptionContentType;
    }

    public function setDescriptionContentType($descriptionContentType)
    {
        $this->descriptionContentType = $descriptionContentType;
    }

    public function getShowWithoutTime()
    {
        return $this->showWithoutTime;
    }

    public function setShowWithoutTime($showWithoutTime)
    {
        $this->showWithoutTime = $showWithoutTime;
    }

    public function getLocations()
    {
        return $this->locations;
    }

    public function setLocations($locations)
    {
        $this->locations = $locations;
    }

    public function getVirtualLocations()
    {
        return $this->virtualLocations;
    }

    public function setVirtualLocations($virtualLocations)
    {
        $this->virtualLocations = $virtualLocations;
    }

    public function getLinks()
    {
        return $this->links;
    }

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

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /* Deprecated in newest JSCalendar spec */
    public function getRecurrenceRule()
    {
        return $this->recurrenceRule;
    }

    /* Deprecated in newest JSCalendar spec */
    public function setRecurrenceRule($recurrenceRule)
    {
        trigger_error(
            "Called method " . __METHOD__ . " is outdated, use " . __METHOD__ . "s instead.",
            E_USER_DEPRECATED
        );

        $this->recurrenceRule = $recurrenceRule;
    }

    public function getRecurrenceRules()
    {
        return $this->recurrenceRules;
    }

    public function setRecurrenceRules($recurrenceRules)
    {
        $this->recurrenceRules = $recurrenceRules;
    }

    public function getRecurrenceOverrides()
    {
        return $this->recurrenceOverrides;
    }

    public function setRecurrenceOverrides($recurrenceOverrides)
    {
        $this->recurrenceOverrides = $recurrenceOverrides;
    }

    public function getExcluded()
    {
        return $this->excluded;
    }

    public function setExcluded($excluded)
    {
        $this->excluded = $excluded;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getFreeBusyStatus()
    {
        return $this->freeBusyStatus;
    }

    public function setFreeBusyStatus($freeBusyStatus)
    {
        $this->freeBusyStatus = $freeBusyStatus;
    }

    public function getPrivacy()
    {
        return $this->privacy;
    }

    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    public function getParticipants()
    {
        return $this->participants;
    }

    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    public function getUseDefaultAlerts()
    {
        return $this->useDefaultAlerts;
    }

    public function setUseDefaultAlerts($useDefaultAlerts)
    {
        $this->useDefaultAlerts = $useDefaultAlerts;
    }

    public function getAlerts()
    {
        return $this->alerts;
    }

    public function setAlerts($alerts)
    {
        $this->alerts = $alerts;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function addCustomProperty($propertyName, $value)
    {
        $this->customProperties[$propertyName] = $value;
    }

    public function getCustomProperties()
    {
        return $this->customProperties;
    }

    public function getBaseEventId()
    {
        return $this->baseEventId;
    }

    public function setBaseEventId($baseEventId)
    {
        $this->baseEventId = $baseEventId;
    }

    public function getCalendarIds()
    {
        return $this->calendarIds;
    }

    public function setCalendarIds($calendarIds)
    {
        $this->calendarIds = $calendarIds;
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

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getVLocations()
    {
        return $this->vLocations;
    }

    public function setVLocations($vLocations)
    {
        $this->vLocations = $vLocations;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getRecurrenceId()
    {
        return $this->recurrenceId;
    }

    public function setRecurrenceId($recurrenceId)
    {
        $this->recurrenceId = $recurrenceId;
    }

    public function getSentBy()
    {
        return $this->sentBy;
    }

    public function setSentBy($sentBy)
    {
        $this->sentBy = $sentBy;
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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getRequestStatus()
    {
        return $this->requestStatus;
    }

    public function setRequestStatus($requestStatus)
    {
        $this->requestStatus = $requestStatus;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "id" => $this->getId(),
            "calendarId" => $this->getCalendarId(),
            "participantId" => $this->getParticipantId(),
            "start" => $this->getStart(),
            "duration" => $this->getDuration(),
            "status" => $this->getStatus(),
            "@type" => $this->getType(),
            "uid" => $this->getUid(),
            "relatedTo" => $this->getRelatedTo(),
            "prodId" => $this->getProdId(),
            "created" => $this->getCreated(),
            "updated" => $this->getUpdated(),
            "sequence" => $this->getSequence(),
            "title" => $this->getTitle(),
            "description" => $this->getDescription(),
            "descriptionContentType" => $this->getDescriptionContentType(),
            "showWithoutTime" => $this->getShowWithoutTime(),
            "locations" => $this->getLocations(),
            "virtualLocations" => $this->getVirtualLocations(),
            "links" => $this->getLinks(),
            "locale" => $this->getLocale(),
            "keywords" => $this->getKeywords(),
            "recurrenceRule" => $this->getRecurrenceRule(),
            "recurrenceRules" => $this->getRecurrenceRules(),
            "recurrenceOverrides" => $this->getRecurrenceOverrides(),
            "excluded" => $this->getExcluded(),
            "priority" => $this->getPriority(),
            "freeBusyStatus" => $this->getFreeBusyStatus(),
            "privacy" => $this->getPrivacy(),
            "replyTo" => $this->getReplyTo(),
            "participants" => $this->getParticipants(),
            "useDefaultAlerts" => $this->getUseDefaultAlerts(),
            "alerts" => $this->getAlerts(),
            "timeZone" => $this->getTimeZone(),
            "color" => $this->getColor(),
            "baseEventId" => $this->getBaseEventId(),
            "calendarIds" => $this->getCalendarIds() ? (object)$this->getCalendarIds() : null,
            "isDraft" => $this->getIsDraft(),
            "isOrigin" => $this->getIsOrigin(),
            "utcStart" => $this->getUtcStart(),
            "utcEnd" => $this->getUtcEnd(),
            "method" => $this->getMethod(),
            "vLocations" => $this->getVLocations(),
            "coordinates" => $this->getCoordinates(),
            "recurrenceId" => $this->getRecurrenceId(),
            "sentBy" => $this->getSentBy(),
            "mayInviteSelf" => $this->getMayInviteSelf(),
            "mayInviteOthers" => $this->getMayInviteOthers(),
            "hideAttendees" => $this->getHideAttendees(),
            "url" => $this->getUrl(),
            "requestStatus" => $this->getRequestStatus(),
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
            "relatedTo" => "Relation",
            "vLocations" => "Location",
        ];

        if (is_string($json)) {
            $json = json_decode($json);
        }

        if (is_array($json)) {
            return parent::fromJsonArray($json);
        }

        $classInstance = new self();

        foreach ($json as $key => $value) {
            // The "@type" poperty is defined as "type" in the custom classes.
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
                // PatchObject represents partial updates, not full events.
                $recurrenceOverrides = [];
                foreach ($value as $id => $override) {
                    $patchObjectClass = "OpenXPort\Jmap\Calendar\PatchObject";
                    $patchObject = $patchObjectClass::fromJson($override);

                    $recurrenceOverrides[$id] = $patchObject;
                }

                $classInstance->setRecurrenceOverrides($recurrenceOverrides);
            } else {
                // These properties are saved as associative arrays, so doing this prevents them from being
                // saved as stdClass objects through json_decode().
                if (
                    $key == "keywords" || $key == "replyTo" ||
                    $key == "calendarIds" || $key == "customProperties" ||
                    $key == "requestStatus"
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
        if ($this->recurrenceOverrides) {
            foreach ($this->recurrenceOverrides as $id => $override) {
                $override->sanitizeFreeText();
            }
        }
        if ($this->vLocations) {
            foreach ($this->vLocations as $id => $vloc) {
                $vloc->sanitizeFreeText();
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

        $this->title = AdapterUtil::reencode($this->title);
        $this->description = AdapterUtil::reencode($this->description);
        $this->keywords = AdapterUtil::reencode($this->keywords);
    }
}
