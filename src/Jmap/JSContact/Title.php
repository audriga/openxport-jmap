<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Title extends TypeableEntity implements JsonSerializable
{
    /** @var string $title (mandatory) */
    private $title;

    /** @var string $organization (optional) */
    private $organization;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getOrganization()
    {
        return $this->organization;
    }

    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "title" => $this->getTitle(),
            "organization" => $this->getOrganization()
        ];
    }
}
