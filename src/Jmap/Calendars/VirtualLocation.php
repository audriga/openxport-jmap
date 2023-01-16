<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;

class VirtualLocation implements JsonSerializable
{
    private $type;
    private $name;
    private $description;
    private $uri;
    private $features;

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

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function setFeatures($features)
    {
        $this->features = $features;
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
     * Parses a VirtualLocation object from the given JSON representation.
     * 
     * @param mixed $json String/Array/Object containing a virtual location in the JSCalendar format.
     * 
     * @return array VirtualLocation object or array containing any properties that can be
     * parsed from the given JSON string/array/object.
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        $virtualLocations = [];


        // In JSCalendar, locations are stored in an Id[VirtualLocation] array. Therefore we must loop through
        // each entry in that array and create a VirtualLocation object for that specific one.
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

                if (!method_exists($classInstance, $setPropertyMethod)) {
                    // TODO: same as with property check, add a logger maybe.
                    continue;
                }

                if ($key == "features") {
                    $value = (array) $value;
                }

                // Set the property in the class' instance.
                $classInstance->{"$setPropertyMethod"}($value);
            }

            $virtualLocations[$id] = $classInstance;
        }

        return $virtualLocations;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "@type" => $this->getType(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "uri" => $this->getUri(),
            "features" => $this->getFeatures()
        ];

        foreach ($this->getCustomProperties() as $name => $value) {
            $objectProperties[$name] = $value;
        }

        return (object) $objectProperties;
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
