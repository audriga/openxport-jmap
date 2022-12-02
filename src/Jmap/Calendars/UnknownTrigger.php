<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class UnknownTrigger implements JsonSerializable
{
    private $type;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Parses a OffsetTrigger object from a given JSON representation of an unkown trigger type.
     * 
     * @param string|array|object $json Some form of JSON representation of a trigger that is not
     * absolute or offset in the JSCalendar format.
     * @return UnknownTrigger Instance of the UnknownTrigger class containing the @type property
     * as parsed from the input.
     */
    public static function fromJson($json)
    {
        $classInstance = new UnknownTrigger();

        if (is_string($json)) {
            $json = json_decode($json);
        }

        foreach ($json as $key => $value) {
            if (!property_exists($classInstance, $key)) {
                // Skipping parameters is to be expected here.
                continue;
            }

            // Since all of the properties are private, using this will allow acces to the setter
            // functions of any given property. 
            // Caution! In order for this to work, every setter method needs to match the property
            // name. So for a var fooBar, the setter needs to be named setFooBar($fooBar).
            $setPropertyMethod = "set" . ucfirst($key);

            if (!method_exists($classInstance, $setPropertyMethod)) {
                // TODO: this shouldn't happen on the other hand, add a logger.
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
            "@type" => $this->getType()
        ];
    }
}
