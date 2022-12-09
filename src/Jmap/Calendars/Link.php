<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

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

        $links = [];


        // In JSCalendar, links are stored in an Id[Link] array. Therefore we must loop through
        // each entry in that array and create a Link object for that specific one.
        foreach ($json as $id => $object) {

            $classInstance = new Link();

            foreach ($object as $key => $value) {
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

                // Set the property in the class' instance.
                $classInstance->{"$setPropertyMethod"}($value);
            }

            $links[$id] = $classInstance;
        }

        return $links;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "href" => $this->getHref(),
            "cid" => $this->getCid(),
            "contentType" => $this->getContentType(),
            "size" => $this->getSize(),
            "rel" => $this->getRel(),
            "display" => $this->getDisplay(),
            "title" => $this->getTitle()
        ];
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
