<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class VirtualLocation implements JsonSerializable
{
    private $type;
    private $name;
    private $description;
    private $uri;

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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "uri" => $this->getUri()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
