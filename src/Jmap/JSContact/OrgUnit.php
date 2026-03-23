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
