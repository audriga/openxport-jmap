<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Jmap\Task\OffsetTrigger as TaskOffsetTrigger;
use OpenXPort\Util\Logger;

class OffsetTrigger implements JsonSerializable
{
    private $type;
    private $offset;
    private $relativeTo;

    private $customProperties;

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

    public function addCustomProperty($propertyName, $value)
    {
        $this->customProperties[$propertyName] = $value;
    }

    public function getCustomProperties()
    {
        return $this->customProperties;
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
        $classInstance = new self();

        if (is_string($json)) {
            $json = json_decode($json);
        }

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
            $classInstance->{"$setPropertyMethod"}($value);
        }

        return $classInstance;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties  = [
            "@type" => $this->getType(),
            "offset" => $this->getOffset(),
            "relativeTo" => $this->getRelativeTo()
        ];

        foreach ($this->getCustomProperties() as $name => $value) {
            $objectProperties[$name] = $value;
        }

        return (object) $objectProperties;
    }
}
