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
