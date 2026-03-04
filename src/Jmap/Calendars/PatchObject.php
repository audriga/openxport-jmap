<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class PatchObject implements JsonSerializable
{
    /**
     * Map of JSCalendar patch paths to values, e.g.:
     *  - "start" => "2025-03-05T10:00:00"
     *  - "participants/xxx/participationStatus" => "declined"
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

    public function removeProperty($path)
    {
        unset($this->properties[$path]);
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
