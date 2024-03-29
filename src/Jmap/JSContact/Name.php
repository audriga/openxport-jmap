<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Name extends TypeableEntity implements JsonSerializable
{
    /** @var NameComponent[] $components (mandatory) */
    private $components;

    /** @var string $locale (optional) - NOTE deprecated in draft-ietf-calext-jscontact-vcard-06 */
    private $locale;

    /** @var array $sortAs (optional) */
    private $sortAs;

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

    /* Deprecated in newest JSContact spec */
    public function getLocale()
    {
        return $this->locale;
    }

    /* Deprecated in newest JSContact spec */
    public function setLocale($locale)
    {
        trigger_error("Name.locale property will not be supported in a future version.", E_USER_DEPRECATED);
        $this->locale = $locale;
    }

    public function getSortAs()
    {
        return $this->sortAs;
    }

    public function setSortAs($sortAs)
    {
        $this->sortAs = $sortAs;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getAtType(),
            "type" => $this->getType(),
            "components" => $this->getComponents(),
            "locale" => $this->getLocale(),
            "sortAs" => $this->getSortAs()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
