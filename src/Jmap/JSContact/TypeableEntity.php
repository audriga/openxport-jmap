<?php

namespace OpenXPort\Jmap\JSContact;

class TypeableEntity
{
    /** @var string $atType
     * This is the @type property, used for various objects in JSContact
     */
    protected $atType;

    public function getAtType()
    {
        return $this->atType;
    }

    public function setAtType($atType)
    {
        $this->atType = $atType;
    }
}
