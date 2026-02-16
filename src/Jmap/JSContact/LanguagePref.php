<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class LanguagePref extends TypeableEntity implements JsonSerializable
{
    /**
     * language: String (mandatory).
     * MUST be a language tag as in RFC 5646 (e.g. "en", "fr-CA"). [web:58]
     *
     * @var string
     */
    private $language;

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
        // @type MUST be "LanguagePref" if set. 
        $this->setAtType('LanguagePref');
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
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
            "@type"    => $this->getAtType(),   // MUST be "LanguagePref" if present. 
            "language" => $this->getLanguage(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
