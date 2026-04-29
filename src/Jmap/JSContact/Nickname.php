<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Nickname extends TypeableEntity implements JsonSerializable
{
    /**
     * @var string|null
     */
    private $name;

    public function __construct($name = null)
    {
        $this->setAtType('Nickname');

        if ($name !== null) {
            $this->name = $name;
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

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

        $instance = new self();

        if (isset($json->name)) {
            $instance->setName($json->name);
        }

        return $instance;
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
