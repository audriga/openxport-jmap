<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

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

    public function getLinkIds()
    {
        trigger_error(
            "Called method " . __METHOD__ . " is outdated, use getLinks instead.",
            E_USER_DEPRECATED
        );

        return $this->linkIds;
    }

    public function setLinkIds($linkIds)
    {
        trigger_error(
            "Called method " . __METHOD__ . " is outdated, use setLinks instead.",
            E_USER_DEPRECATED
        );

        $this->linkIds = $linkIds;
    }

    /**
     * Parses a Location object from the given JSON representation.
     * 
     * @param mixed $json String/Array/Object containing a location in the JSCalendar format.
     * 
     * @return array Location object or array containing any properties that can be
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

            $classInstance = new Location();

            foreach ($object as $key => $value) {
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
        return (object)[
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
