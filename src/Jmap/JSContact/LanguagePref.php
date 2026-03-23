<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class LanguagePref extends TypeableEntity implements JsonSerializable
{
    /** @var string|null */
    private $language;

    /** @var array<string,bool>|null */
    private $contexts;

    /** @var int|null */
    private $pref;

    public function __construct($language = null, $contexts = null, $pref = null)
    {
        $this->setAtType('LanguagePref');

        if ($language !== null) {
            $this->language = $language;
        }
        if ($contexts !== null) {
            $this->contexts = $contexts;
        }
        if ($pref !== null) {
            $this->pref = $pref;
        }
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getContexts()
    {
        return $this->contexts;
    }

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
            '@type'    => $this->getAtType(),
            'language' => $this->getLanguage(),
            'contexts' => $this->getContexts(),
            'pref'     => $this->getPref(),
        ], static function ($v) {
            return $v !== null;
        });
    }
}
