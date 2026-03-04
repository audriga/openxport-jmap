<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\Logger;

class RecurrenceRule extends JSCalendarDataType implements JsonSerializable
{
    private $type;
    private $frequency;
    private $interval;
    private $byDay;
    private $byMonth;
    private $bySetPosition;
    private $count;
    private $until;

    private $customProperties;

    public function __construct(
        $frequency = null,
        $interval = null,
        $byDay = null,
        $byMonth = null,
        $bySetPosition = null,
        $count = null,
        $until = null
    ) {
        $this->setType('RecurrenceRule');

        if ($frequency !== null) {
            $this->setFrequency($frequency);
        }
        if ($interval !== null) {
            $this->setInterval($interval);
        }
        if ($byDay !== null) {
            $this->setByDay($byDay);
        }
        if ($byMonth !== null) {
            $this->setByMonth($byMonth);
        }
        if ($bySetPosition !== null) {
            $this->setBySetPosition($bySetPosition);
        }
        if ($count !== null) {
            $this->setCount($count);
        }
        if ($until !== null) {
            $this->setUntil($until);
        }
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }

    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    public function getInterval()
    {
        return $this->interval;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    public function getByDay()
    {
        return $this->byDay;
    }

    /**
     * @param NDay[]|null $byDay
     */
    public function setByDay($byDay)
    {
        $this->byDay = $byDay;
    }

    public function getByMonth()
    {
        return $this->byMonth;
    }

    public function setByMonth($byMonth)
    {
        $this->byMonth = $byMonth;
    }

    public function getBySetPosition()
    {
        return $this->bySetPosition;
    }

    public function setBySetPosition($bySetPosition)
    {
        $this->bySetPosition = $bySetPosition;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getUntil()
    {
        return $this->until;
    }

    public function setUntil($until)
    {
        $this->until = $until;
    }

    public function addCustomProperty($propertyName, $value)
    {
        $this->customProperties[$propertyName] = $value;
    }

    public function getCustomProperties()
    {
        return $this->customProperties;
    }

    /**
     * Parses a RecurrenceRule object from the given JSON representation.
     *
     * @param mixed $json String/Array/object containing a recurrence rule in the JSCalendar format.
     *
     * @return RecurrenceRule RecurrenceRule object containing any properties that can be
     * parsed from the given JSON string/array.
     */
    public static function fromJson($json)
    {
        $classInstance = new RecurrenceRule();

        if (is_string($json)) {
            $json = json_decode($json);
        }

        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        // Always build a single RecurrenceRule instance here.

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

            // Access the setter method of the given property.
            if ($key == "byDay") {
                if (is_array($value)) {
                    $ndays = [];
                    foreach ($value as $dayJson) {
                        $ndays[] = NDay::fromJson($dayJson);
                    }
                    $classInstance->{$setPropertyMethod}($ndays);
                } else {
                    $classInstance->{$setPropertyMethod}([NDay::fromJson($value)]);
                }
            } else {
                $classInstance->{$setPropertyMethod}($value);
            }
        }

        return $classInstance;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "@type" => $this->getType(),
            "frequency" => $this->getFrequency(),
            "interval" => $this->getInterval(),
            "byDay" => $this->getByDay(),
            "byMonth" => $this->getByMonth(),
            "bySetPosition" => $this->getBySetPosition(),
            "count" => $this->getCount(),
            "until" => $this->getUntil()
        ];

        $custom = $this->getCustomProperties() !== null ? $this->getCustomProperties() : [];
        foreach ($custom as $name => $value) {
            $objectProperties[$name] = $value;
        }

        return (object) array_filter($objectProperties, function ($val) {
            return !is_null($val);
        });
    }
}
