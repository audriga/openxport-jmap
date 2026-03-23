<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Nickname extends TypeableEntity implements JsonSerializable
{
    private $type = "Nickname";
    /**
     * @var string|null
     */
    private $name;

    public function __construct($name = null)
    {
        if ($name !== null) {
            $this->name = $name;
        }
    }
    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            '@type' => $this->getAtType(),
            'name'  => $this->getName(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
