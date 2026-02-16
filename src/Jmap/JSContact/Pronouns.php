<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Pronouns extends TypeableEntity implements JsonSerializable
{
    /** @var string pronouns (mandatory) */
    private $pronouns;

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
        // @type MUST be "Pronouns" if set.
        $this->setAtType('Pronouns');
    }

    public function getPronouns()
    {
        return $this->pronouns;
    }

    public function setPronouns($pronouns)
    {
        $this->pronouns = $pronouns;
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
            "@type"    => $this->getAtType(),   // MUST be "Pronouns" if present.
            "pronouns" => $this->getPronouns(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
