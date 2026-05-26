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

    public function __construct($pronouns = null, $contexts = null, $pref = null)
    {
        $this->setAtType('Pronouns');

        $this->setPronouns($pronouns);

        if ($contexts !== null) {
            $this->setContexts($contexts);
        }
        if ($pref !== null) {
            $this->setPref($pref);
        }
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

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

        $instance = new self();

        if (isset($json->pronouns)) {
            $instance->setPronouns($json->pronouns);
        }
        if (isset($json->contexts)) {
            $instance->setContexts((array) $json->contexts);
        }
        if (isset($json->pref)) {
            $instance->setPref($json->pref);
        }

        return $instance;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"    => $this->getAtType(),
            "pronouns" => $this->getPronouns(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
