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
     * Check if this patch represents an excluded occurrence
     *
     * @return bool
     */
    public function isExcluded()
    {
        return $this->getExcluded() === true;
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
