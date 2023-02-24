<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Name extends TypeableEntity implements JsonSerializable
{
    /** @var NameComponent[] $components (mandatory) */
    private $components;

    /** @var string $locale (optional) - NOTE deprecated in draft-ietf-calext-jscontact-vcard-06 */
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
        trigger_error("Name.locale property will not be supported in a future version.", E_USER_DEPRECATED);
        return $this->locale;
    }

    public function setLocale($locale)
    {
        trigger_error("Name.locale property will not be supported in a future version.", E_USER_DEPRECATED);
        $this->locale = $locale;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->type,
            "components" => $this->components,
            "locale" => $this->locale
        ], function ($val) {
            return !is_null($val);
        });
    }
}
