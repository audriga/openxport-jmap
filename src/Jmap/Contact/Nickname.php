<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

class Nickname extends TypeableEntity implements JsonSerializable
{
    /**
     * name: String (mandatory).
     *
     * @var string
     */
    private $name;

    /**
     * contexts: String[Boolean] (optional).
     *
     * @var array<string,bool>|null
     */
    private $contexts;

    /**
     * pref: UnsignedInt (optional).
     *
     * @var int|null
     */
    private $pref;

    public function __construct()
    {
        // @type MUST be "Nickname" if set.
        $this->setAtType('Nickname');
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array<string,bool>|null
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @param array<string,bool>|null $contexts
     */
    public function setContexts($contexts)
    {
        $this->contexts = $contexts;
    }

    public function getPref()
    {
        return $this->pref;
    }

    public function setPref($pref)
    {
        $this->pref = $pref;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"    => $this->getAtType(),   // MUST be "Nickname" if present.
            "name"     => $this->getName(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
