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

    // Properties called by mapAllJmapPropertiesToICal()

    public function getExcluded()
    {
        return $this->properties['excluded'] ?? null;
    }

    public function setExcluded($excluded)
    {
        $this->properties['excluded'] = $excluded;
    }

    public function getTitle()
    {
        return $this->properties['title'] ?? null;
    }

    public function setTitle($title)
    {
        $this->properties['title'] = $title;
    }

    public function getDescription()
    {
        return $this->properties['description'] ?? null;
    }

    public function setDescription($description)
    {
        $this->properties['description'] = $description;
    }

    public function getCreated()
    {
        return $this->properties['created'] ?? null;
    }

    public function setCreated($created)
    {
        $this->properties['created'] = $created;
    }

    public function getUpdated()
    {
        return $this->properties['updated'] ?? null;
    }

    public function setUpdated($updated)
    {
        $this->properties['updated'] = $updated;
    }

    public function getStart()
    {
        return $this->properties['start'] ?? null;
    }

    public function setStart($start)
    {
        $this->properties['start'] = $start;
    }

    public function getDuration()
    {
        return $this->properties['duration'] ?? null;
    }

    public function setDuration($duration)
    {
        $this->properties['duration'] = $duration;
    }

    public function getTimeZone()
    {
        return $this->properties['timeZone'] ?? null;
    }

    public function setTimeZone($timeZone)
    {
        $this->properties['timeZone'] = $timeZone;
    }

    public function getShowWithoutTime()
    {
        return $this->properties['showWithoutTime'] ?? null;
    }

    public function setShowWithoutTime($showWithoutTime)
    {
        $this->properties['showWithoutTime'] = $showWithoutTime;
    }

    public function getKeywords()
    {
        return $this->properties['keywords'] ?? null;
    }

    public function setKeywords($keywords)
    {
        $this->properties['keywords'] = $keywords;
    }

    public function getLocations()
    {
        return $this->properties['locations'] ?? null;
    }

    public function setLocations($locations)
    {
        $this->properties['locations'] = $locations;
    }

    public function getFreeBusyStatus()
    {
        return $this->properties['freeBusyStatus'] ?? null;
    }

    public function setFreeBusyStatus($freeBusyStatus)
    {
        $this->properties['freeBusyStatus'] = $freeBusyStatus;
    }

    public function getStatus()
    {
        return $this->properties['status'] ?? null;
    }

    public function setStatus($status)
    {
        $this->properties['status'] = $status;
    }

    public function getColor()
    {
        return $this->properties['color'] ?? null;
    }

    public function setColor($color)
    {
        $this->properties['color'] = $color;
    }

    public function getPriority()
    {
        return $this->properties['priority'] ?? null;
    }

    public function setPriority($priority)
    {
        $this->properties['priority'] = $priority;
    }

    public function getAlerts()
    {
        $alerts = $this->properties['alerts'] ?? null;

        if (is_null($alerts)) {
            return null;
        }

        // Convert stdClass to array
        if (is_object($alerts) && $alerts instanceof \stdClass) {
            $alerts = (array) $alerts;
        }

        // Convert stdClass alerts to Alert objects using Alert::fromJson()
        if (is_array($alerts)) {
            foreach ($alerts as $alert) {
                if (is_object($alert) && $alert instanceof \stdClass) {
                    return Alert::fromJson((object) $alerts);
                }
            }
        }

        return $alerts;
    }
    public function setAlerts($alerts)
    {
        // Ensure alerts is always an array
        if (is_object($alerts) && $alerts instanceof \stdClass) {
            $alerts = (array) $alerts;
        }

        $this->properties['alerts'] = $alerts;
    }

    public function getParticipants()
    {
        return $this->properties['participants'] ?? null;
    }

    public function setParticipants($participants)
    {
        $this->properties['participants'] = $participants;
    }

    public function getLinks()
    {
        $links = $this->properties['links'] ?? null;

        if (is_null($links)) {
            return null;
        }

        if ($links instanceof \stdClass) {
            $links = (array) $links;
        }

        if (!is_array($links)) {
            return null;
        }

        $normalizedLinks = [];

        foreach ($links as $id => $link) {
            $normalizedLink = \OpenXPort\Jmap\Calendar\Link::fromMixed($link);

            if (!is_null($normalizedLink)) {
                $normalizedLinks[$id] = $normalizedLink;
            }
        }
        return $normalizedLinks;
    }

    public function setLinks($links)
    {
        $this->properties['links'] = $links;
    }

    public function isExcluded()
    {
        return $this->getExcluded() === true;
    }

    public function getVirtualLocations()
    {
        return $this->properties['virtualLocations'] ?? null;
    }

    public function setVirtualLocations($virtualLocations)
    {
        $this->properties['virtualLocations'] = $virtualLocations;
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
