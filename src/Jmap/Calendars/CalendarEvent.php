<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

/**
 * Class which represents a JMAP Calendar Event (according to JSCalendar)
 */
class CalendarEvent implements JsonSerializable
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

    public function getRecurrenceRule()
    {
        trigger_error(
            "Called method " . __METHOD__ . " is outdated, use " . __METHOD__ . "s instead.",
            E_USER_DEPRECATED
        );

        return $this->recurrenceRule;
    }

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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
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
            "timeZone" => $this->getTimeZone()
        ];
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
        $classInstance = new CalendarEvent();

        // Array of every variable that has a custom object type.
        $objectVariables = [
            "locations" => "Location",
            "virtualLocations" => "VirtualLocation",
            "links" => "Link",
            "recurrenceRules" => "RecurrenceRule",
            "participants" => "Participant",
            "alerts" => "Alert"
        ];

        if (is_string($json)) {
            $json = json_decode($json);
        }

        if (is_array($json)){
            return self::fromJsonArray($json);
        }

        foreach ($json as $key => $value) {
            // The "@type" poperty is defined as "type" in the custom classes.
            if ($key == "@type") {
                $key = "type";
            }

            if (!property_exists($classInstance, $key)) {
                // TODO: Should probably add a logger to each class that can be called here.
                continue;
            }

            // Since all of the properties are private, using this will allow acces to the setter
            // functions of any given property. 
            // Caution! In order for this to work, every setter method needs to match the property
            // name. So for a var fooBar, the setter needs to be named setFooBar($fooBar).
            $setPropertyMethod = "set" . ucfirst($key);

            if (!method_exists($classInstance, $setPropertyMethod)) {
                // TODO: same as with property check, add a logger maybe.
                continue;
            }

            // Access the setter method of the given property. If the property is an Object in the JSCalendar
            // spec itself, call that class' fromJson method to parse the JSON object accordingly.
            if (array_key_exists($key, $objectVariables)) {
                $classInstance->{"$setPropertyMethod"}(
                    "OpenXPort\Jmap\Calendar\\$objectVariables[$key]"::fromJson($value)
                );
            } else {
                // These properties are saved as associative arrays, so doing this prevents them from being
                // saved as stdClass objects through json_decode().
                if ($key == "keywords" || $key == "replyTo") {
                    $value = (array) $value;
                }

                $classInstance->{"$setPropertyMethod"}($value);
            }
        }

        return $classInstance;
    }

    /**
     * Used by fromJson() to parse an array of JSON CalendarEvent properties.
     */
     private static function fromJsonArray(array $json)
    {
        $jsonEntries = [];

        foreach ($json as $entry) {
            array_push($jsonEntries, self::fromJson($entry));
        }

        return $jsonEntries;
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
            foreach ($this->virtualLocations as $id => $loc) {
                $loc->sanitizeFreeText();
            }
        }
        if ($this->links) {
            foreach ($this->links as $id => $lin) {
                $lin->sanitizeFreeText();
            }
        }
        if ($this->recurrenceOverrides) {
            foreach ($this->recurrenceOverrides as $id => $rec) {
                $rec->sanitizeFreeText();
            }
        }

        $this->title = AdapterUtil::reencode($this->title);
        $this->description = AdapterUtil::reencode($this->description);
        $this->keywords = AdapterUtil::reencode($this->keywords);
    }
}
