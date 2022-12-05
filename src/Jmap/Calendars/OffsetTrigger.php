<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Jmap\Task\OffsetTrigger as TaskOffsetTrigger;

class OffsetTrigger implements JsonSerializable
{
    private $type;
    private $offset;
    private $relativeTo;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function getRelativeTo()
    {
        return $this->relativeTo;
    }

    public function setRelativeTo($relativeTo)
    {
        $this->relativeTo = $relativeTo;
    }

    /**
     * Parses a OffsetTrigger object from a given JSON representation of an offset trigger.
     * 
     * @param string|array|object $json Some form of JSON representation of an offset trigger
     * in the JSCalendar format.
     * @return OffsetTrigger Instance of the OffsetTrigger class containing any properties that
     * could be parsed from the input.
     */
    public static function fromJson($json)
    {
        $classInstance = new OffsetTrigger();

        if (is_string($json)) {
            $json = json_decode($json);
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

            // Access the setter method of the given property.
            $classInstance->{"$setPropertyMethod"}($value);
        }

        return $classInstance;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "offset" => $this->getOffset(),
            "relativeTo" => $this->getRelativeTo()
        ];
    }
}
