<?php

namespace OpenXPort\Jmap\Contact;

class TypeableEntity
{
    /** @var string $atType
     * This is the @type property, used for various objects in Contact
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
