<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\Logger;

class Relation implements JsonSerializable
{
    private $type;
    private $relation;

    private $customProperties;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getRelation()
    {
        return $this->relation;
    }

    public function setRelation($relation)
    {
        $this->relation = $relation;
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
     * Parses a Relation object from the given JSON representation.
     *
     * @param mixed $json String/Array containing a relation in the JSCalendar format.
     *
     * @return array String[Relation] array containing any properties that can be
     * parsed from the given JSON string/array.
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        $relations = [];


        // In JSCalendar, relations are stored in a String[Relation] array. Therefore we must loop through
        // each entry in that array and create a Relation object for that specific one.
        foreach ($json as $string => $object) {
            $classInstance = new self();

            foreach ($object as $key => $value) {
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

                // Since all of the properties are private, using this will allow acces to the setter
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

                if ($key == "relation") {
                    $value = (array) $value;
                }

                // Set the property in the class' instance.
                $classInstance->{"$setPropertyMethod"}($value);
            }

            $relations[$string] = $classInstance;
        }

        return $relations;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "@type" => $this->getType(),
            "relation" => $this->getRelation()
        ];

        foreach ($this->getCustomProperties() as $name => $value) {
            $objectProperties[$name] = $value;
        }

        return (object) array_filter($objectProperties, function ($val) {
            return !is_null($val);
        });
    }
}
