<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;

class Location implements JsonSerializable
{
    private $type;
    private $name;
    private $description;
    private $relativeTo;
    private $timeZone;
    private $locationTypes;
    private $coordinates;
    private $links;
    private $linkIds;

    private $customProperties;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getRelativeTo()
    {
        return $this->relativeTo;
    }

    public function setRelativeTo($relativeTo)
    {
        $this->relativeTo = $relativeTo;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public function getLocationTypes()
    {
        return $this->locationTypes;
    }

    public function setLocationTypes($locationTypes)
    {
        $this->locationTypes = $locationTypes;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function setLinks($links)
    {
        $this->links = $links;
    }

    /* Deprecated in newest JMAP Calendar spec */
    public function getLinkIds()
    {
        return $this->linkIds;
    }

    /* Deprecated in newest JSContact spec */
    public function setLinkIds($linkIds)
    {
        trigger_error(
            "Called method " . __METHOD__ . " is outdated, use setLinks instead.",
            E_USER_DEPRECATED
        );

        $this->linkIds = $linkIds;
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
     * Parses a Location object from the given JSON representation.
     *
     * @param mixed $json String/Array/Object containing a location in the JSCalendar format.
     *
     * @return array Id[Location] array containing any properties that can be
     * parsed from the given JSON string/array/object.
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        $locations = [];


        // In JSCalendar, locations are stored in an Id[Location] array. Therefore we must loop through
        // each entry in that array and create a Location object for that specific one.
        foreach ($json as $id => $object) {
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

                if ($key == "links" || $key == "linkIds") {
                    $value = Link::fromJson($value);
                }

                // Set the property in the class' instance.
                $classInstance->{"$setPropertyMethod"}($value);
            }

            $locations[$id] = $classInstance;
        }

        return $locations;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "@type" => $this->getType(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "relativeTo" => $this->getRelativeTo(),
            "timeZone" => $this->getTimeZone(),
            "locationTypes" => $this->getLocationTypes(),
            "coordinates" => $this->getCoordinates(),
            "links" => $this->getLinks(),
            "linkIds" => $this->getLinkIds()
        ];

        foreach ($this->getCustomProperties() as $name => $value) {
            $objectProperties[$name] = $value;
        }

        return (object) array_filter($objectProperties, function ($val) {
            return !is_null($val);
        });
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        $this->name = AdapterUtil::reencode($this->name);
        $this->description = AdapterUtil::reencode($this->description);
    }
}
