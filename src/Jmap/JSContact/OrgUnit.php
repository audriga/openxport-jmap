<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class OrgUnit extends TypeableEntity implements JsonSerializable
{
    /**
     * name: String (mandatory).
     *
     * @var string
     */
    private $name;

    /**
     * sortAs: String (optional).
     *
     * @var string|null
     */
    private $sortAs;

    public function __construct($name, $sortAs = null)
    {
        $this->setAtType('OrgUnit');

        $this->setName($name);

        if ($sortAs !== null) {
            $this->setSortAs($sortAs);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSortAs()
    {
        return $this->sortAs;
    }

    public function setSortAs($sortAs)
    {
        $this->sortAs = $sortAs;
    }

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

    // name is mandatory, so default to empty string if missing
        $name = isset($json->name) ? $json->name : '';
        $sortAs = isset($json->sortAs) ? $json->sortAs : null;

        return new self($name, $sortAs);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"  => $this->getAtType(),
            "name"   => $this->getName(),
            "sortAs" => $this->getSortAs(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
