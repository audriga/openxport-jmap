<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Name extends TypeableEntity implements JsonSerializable
{
    /** @var NameComponent[] $components (mandatory) */
    private $components;

    /** @var string $locale (optional) */
    private $locale;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getComponents()
    {
        return $this->components;
    }

    public function setComponents($components)
    {
        $this->components = $components;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "components" => $this->getComponents(),
            "locale" => $this->getLocale()
        ];
    }
}
