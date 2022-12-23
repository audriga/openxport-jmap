<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class NDay implements JsonSerializable
{
    private $type;
    private $day;
    private $nthOfPeriod;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getDay()
    {
        return $this->day;
    }

    // always lowercase
    public function setDay($day)
    {
        $this->day = strtolower($day);
    }

    public function getNthOfPeriod()
    {
        return $this->nthOfPeriod;
    }

    public function setNthOfPeriod($nthOfPeriod)
    {
        $this->nthOfPeriod = $nthOfPeriod;
    }

    /**
     * Parses a NDay object from a given JSON representation of a day.
     * 
     * @param string|array|object $json Some form of JSON representation of a day.
     * in the JSCalendar format.
     * @return NDay Instance of the NDay class containing any properties that
     * could be parsed from the input.
     */
    public static function fromJson($json)
    {
        $classInstance = new NDay();

        if (is_string($json)) {
            $json = json_decode($json);
        }

        if (is_array($json)) {
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

            // Since all of the properties are private, using this will allow access to the setter
            // functions of any given property. 
            // Caution! In order for this to work, every setter method needs to match the property
            // name. So for a var fooBar, the setter needs to be named setFooBar($fooBar).
            $setPropertyMethod = "set" . ucfirst($key);

            if (!method_exists($classInstance, $setPropertyMethod)) {
                // TODO: same as with property check, add a logger maybe.
                continue;
            }

            // Access the setter method of the given property.
            $classInstance->{"$setPropertyMethod"}($value);
        }

        return $classInstance;
    }

    /**
     * Used by fromJson() to parse an array of JSON NDay objects, as they are stored in a
     * nDay[] array in the JSCalendar format.
     */
    private static function fromJsonArray(array $json)
    {
        $jsonEntries = [];

        foreach ($json as $entry) {
            array_push($jsonEntries, self::fromJson($entry));
        }

        return $jsonEntries;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "day" => $this->getDay(),
            "nthOfPeriod" => $this->getNthOfPeriod()
        ];
    }
}
