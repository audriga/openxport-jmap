<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

/**
 * RecurrenceOverrides wrapper.
 *
 * Represents a map of recurrence-id strings to PatchObject instances,
 * similar to the Dart RecurrenceOverrides class.
 *
 * Each key is a recurrence-id (e.g. "2026-03-04T09:00:00") and the value
 * is a PatchObject describing overrides for that occurrence.
 */
class RecurrenceOverrides implements JsonSerializable
{
    /**
     * @var array<string,PatchObject>
     */
    private $overrides = [];

    /**
     * @param array<string,PatchObject> $overrides
     */
    public function __construct(array $overrides = [])
    {
        $this->overrides = $overrides;
    }

    /**
     * @return array<string,PatchObject>
     */
    public function getOverrides()
    {
        return $this->overrides;
    }

    /**
     * @param array<string,PatchObject> $overrides
     */
    public function setOverrides(array $overrides)
    {
        $this->overrides = $overrides;
    }

    public function addOverride($recurrenceId, PatchObject $patch)
    {
        $this->overrides[$recurrenceId] = $patch;
    }

    public function removeOverride($recurrenceId)
    {
        unset($this->overrides[$recurrenceId]);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $result = [];

        foreach ($this->overrides as $id => $patchObject) {
            $result[$id] = $patchObject;
        }

        return (object) $result;
    }

    /**
     * @param mixed $json String|array|object containing recurrenceOverrides.
     *
     * @return RecurrenceOverrides
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        $overrides = [];

        foreach ((array) $json as $id => $patchJson) {
            $overrides[$id] = PatchObject::fromJson($patchJson);
        }

        return new self($overrides);
    }
}
