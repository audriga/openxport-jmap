<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;

class Link implements JsonSerializable
{
    private $type;
    private $href;
    private $cid;
    private $contentType;
    private $size;
    private $rel;
    private $display;
    private $title;

    private $customProperties = [];

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function setHref($href)
    {
        $this->href = $href;
    }

    public function getCid()
    {
        return $this->cid;
    }

    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getRel()
    {
        return $this->rel;
    }

    public function setRel($rel)
    {
        $this->rel = $rel;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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
     * Parses a single Link object from the given JSON representation.
     *
     * @param mixed $json String/Array/Object containing a single link in the JSCalendar format.
     *
     * @return Link|null
     */
    public static function fromJsonObject($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        if (is_array($json)) {
            $json = (object) $json;
        }

        if (!($json instanceof \stdClass)) {
            return null;
        }

        $classInstance = new self();

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

            // Set the property in the class' instance.
            $classInstance->{"$setPropertyMethod"}($value);
        }

        return $classInstance;
    }

    /**
     * Parses a Link object from the given JSON representation.
     *
     * @param mixed $json String/Array/Object containing a link in the JSCalendar format.
     *
     * @return array Id[Link] array containing any properties that can be
     * parsed from the given JSON string/array/object.
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        if (!is_array($json)) {
            return [];
        }

        $links = [];


        // In JSCalendar, links are stored in an Id[Link] array. Therefore we must loop through
        // each entry in that array and create a Link object for that specific one.
        foreach ($json as $id => $object) {
            $classInstance = self::fromJsonObject($object);

            if (!is_null($classInstance)) {
                $links[$id] = $classInstance;
            }
        }

        return $links;
    }

    /**
     * Parses a mixed value into a single Link object.
     *
     * @param mixed $link String/Array/Object/Link containing a single link in the JSCalendar format.
     *
     * @return Link|null
     */
    public static function fromMixed($link)
    {
        if ($link instanceof self) {
            return $link;
        }

        return self::fromJsonObject($link);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $objectProperties = [
            "@type" => $this->getType(),
            "href" => $this->getHref(),
            "cid" => $this->getCid(),
            "contentType" => $this->getContentType(),
            "size" => $this->getSize(),
            "rel" => $this->getRel(),
            "display" => $this->getDisplay(),
            "title" => $this->getTitle()
        ];

        if (!is_null($this->getCustomProperties())) {
            foreach ($this->getCustomProperties() as $name => $value) {
                $objectProperties[$name] = $value;
            }
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
        $this->title = AdapterUtil::reencode($this->title);
    }
}
