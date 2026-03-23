<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class PatchObject implements JsonSerializable
{
    /**
     * Map of JSCalendar patch paths to values, e.g.:
     *  - "start" => "2025-03-05T10:00:00"
     *  - "participants/xxx/participationStatus" => "declined"
     *  - "excluded" => true (to cancel this occurrence)
     *
     * @var array<string,mixed>
     */
    private $properties = [];

    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    /**
     * @return array<string,mixed>
     */
    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperty($path, $value)
    {
        $this->properties[$path] = $value;
    }

    public function getProperty($path)
    {
        return $this->properties[$path] ?? null;
    }

    public function hasProperty($path)
    {
        return isset($this->properties[$path]);
    }

    public function removeProperty($path)
    {
        unset($this->properties[$path]);
    }

    /**
     * Get the "excluded" property (true means this occurrence is cancelled)
     *
     * @return bool|null
     */
    public function getExcluded()
    {
        return $this->properties['excluded'] ?? null;
    }

    /**
     * Set the "excluded" property
     *
     * @param bool $excluded
     */
    public function setExcluded($excluded)
    {
        $this->properties['excluded'] = $excluded;
    }

    /**
     * Check if this patch represents an excluded occurrence
     *
     * @return bool
     */
    public function isExcluded()
    {
        return $this->getExcluded() === true;
    }

    /**
     * Get the "title" property
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->properties['title'] ?? null;
    }

    /**
     * Set the "title" property
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->properties['title'] = $title;
    }

    /**
     * Get the "description" property
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->properties['description'] ?? null;
    }

    /**
     * Set the "description" property
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->properties['description'] = $description;
    }

    /**
     * Get the "start" property
     *
     * @return string|null
     */
    public function getStart()
    {
        return $this->properties['start'] ?? null;
    }

    /**
     * Set the "start" property
     *
     * @param string $start
     */
    public function setStart($start)
    {
        $this->properties['start'] = $start;
    }

    /**
     * Get the "duration" property
     *
     * @return string|null
     */
    public function getDuration()
    {
        return $this->properties['duration'] ?? null;
    }

    /**
     * Set the "duration" property
     *
     * @param string $duration
     */
    public function setDuration($duration)
    {
        $this->properties['duration'] = $duration;
    }

    /**
     * Get the "timeZone" property
     *
     * @return string|null
     */
    public function getTimeZone()
    {
        return $this->properties['timeZone'] ?? null;
    }

    /**
     * Set the "timeZone" property
     *
     * @param string|null $timeZone
     */
    public function setTimeZone($timeZone)
    {
        $this->properties['timeZone'] = $timeZone;
    }

    /**
     * Get the "showWithoutTime" property
     *
     * @return bool|null
     */
    public function getShowWithoutTime()
    {
        return $this->properties['showWithoutTime'] ?? null;
    }

    /**
     * Set the "showWithoutTime" property
     *
     * @param bool|null $showWithoutTime
     */
    public function setShowWithoutTime($showWithoutTime)
    {
        $this->properties['showWithoutTime'] = $showWithoutTime;
    }

    /**
     * Get the "status" property
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->properties['status'] ?? null;
    }

    /**
     * Set the "status" property
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->properties['status'] = $status;
    }

    /**
     * Get the "created" property
     *
     * @return string|null
     */
    public function getCreated()
    {
        return $this->properties['created'] ?? null;
    }

    /**
     * Set the "created" property
     *
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->properties['created'] = $created;
    }

    /**
     * Get the "updated" property
     *
     * @return string|null
     */
    public function getUpdated()
    {
        return $this->properties['updated'] ?? null;
    }

    /**
     * Set the "updated" property
     *
     * @param string $updated
     */
    public function setUpdated($updated)
    {
        $this->properties['updated'] = $updated;
    }

    /**
     * Get the "keywords" property
     *
     * @return array|null
     */
    public function getKeywords()
    {
        return $this->properties['keywords'] ?? null;
    }

    /**
     * Set the "keywords" property
     *
     * @param array $keywords
     */
    public function setKeywords($keywords)
    {
        $this->properties['keywords'] = $keywords;
    }

    /**
     * Get the "locations" property
     *
     * @return array|null
     */
    public function getLocations()
    {
        return $this->properties['locations'] ?? null;
    }

    /**
     * Set the "locations" property
     *
     * @param array $locations
     */
    public function setLocations($locations)
    {
        $this->properties['locations'] = $locations;
    }

    /**
     * Get the "freeBusyStatus" property
     *
     * @return string|null
     */
    public function getFreeBusyStatus()
    {
        return $this->properties['freeBusyStatus'] ?? null;
    }

    /**
     * Set the "freeBusyStatus" property
     *
     * @param string $freeBusyStatus
     */
    public function setFreeBusyStatus($freeBusyStatus)
    {
        $this->properties['freeBusyStatus'] = $freeBusyStatus;
    }

    /**
     * Get the "color" property
     *
     * @return string|null
     */
    public function getColor()
    {
        return $this->properties['color'] ?? null;
    }

    /**
     * Set the "color" property
     *
     * @param string $color
     */
    public function setColor($color)
    {
        $this->properties['color'] = $color;
    }

    /**
     * Get the "priority" property
     *
     * @return int|null
     */
    public function getPriority()
    {
        return $this->properties['priority'] ?? null;
    }

    /**
     * Set the "priority" property
     *
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->properties['priority'] = $priority;
    }

    /**
     * Get the "alerts" property
     *
     * @return array|null
     */
    public function getAlerts()
    {
        return $this->properties['alerts'] ?? null;
    }

    /**
     * Set the "alerts" property
     *
     * @param array $alerts
     */
    public function setAlerts($alerts)
    {
        $this->properties['alerts'] = $alerts;
    }

    /**
     * Get the "participants" property
     *
     * @return array|null
     */
    public function getParticipants()
    {
        return $this->properties['participants'] ?? null;
    }

    /**
     * Set the "participants" property
     *
     * @param array $participants
     */
    public function setParticipants($participants)
    {
        $this->properties['participants'] = $participants;
    }

    /**
     * Get the "links" property
     *
     * @return array|null
     */
    public function getLinks()
    {
        return $this->properties['links'] ?? null;
    }

    /**
     * Set the "links" property
     *
     * @param array $links
     */
    public function setLinks($links)
    {
        $this->properties['links'] = $links;
    }

    /**
     * Get the "uid" property
     *
     * @return string|null
     */
    public function getUid()
    {
        return $this->properties['uid'] ?? null;
    }

    /**
     * Set the "uid" property
     *
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->properties['uid'] = $uid;
    }

    /**
     * Get the "prodId" property
     *
     * @return string|null
     */
    public function getProdId()
    {
        return $this->properties['prodId'] ?? null;
    }

    /**
     * Set the "prodId" property
     *
     * @param string $prodId
     */
    public function setProdId($prodId)
    {
        $this->properties['prodId'] = $prodId;
    }

    /**
     * Get the "sequence" property
     *
     * @return int|null
     */
    public function getSequence()
    {
        return $this->properties['sequence'] ?? null;
    }

    /**
     * Set the "sequence" property
     *
     * @param int $sequence
     */
    public function setSequence($sequence)
    {
        $this->properties['sequence'] = $sequence;
    }

    /**
     * Get the "privacy" property
     *
     * @return string|null
     */
    public function getPrivacy()
    {
        return $this->properties['privacy'] ?? null;
    }

    /**
     * Set the "privacy" property
     *
     * @param string $privacy
     */
    public function setPrivacy($privacy)
    {
        $this->properties['privacy'] = $privacy;
    }

    /**
     * Get the "recurrenceRules" property
     *
     * @return array|null
     */
    public function getRecurrenceRules()
    {
        return $this->properties['recurrenceRules'] ?? null;
    }

    /**
     * Set the "recurrenceRules" property
     *
     * @param array $recurrenceRules
     */
    public function setRecurrenceRules($recurrenceRules)
    {
        $this->properties['recurrenceRules'] = $recurrenceRules;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) $this->properties;
    }

    /**
     * @param mixed $json
     *
     * @return PatchObject
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }
        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        return new self((array) $json);
    }
}
