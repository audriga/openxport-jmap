<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class SpeakToAs extends TypeableEntity implements JsonSerializable
{
    /** @var string|null grammaticalGender (optional) */
    private $grammaticalGender;

    /**
     * pronouns: Id[Pronouns] (optional).
     *
     * @var array<string,Pronouns>|null
     */
    private $pronouns;

    public function __construct($grammaticalGender = null, $pronouns = null)
    {
        $this->setAtType('SpeakToAs');

        if ($grammaticalGender !== null) {
            $this->setGrammaticalGender($grammaticalGender);
        }
        if ($pronouns !== null) {
            $this->setPronouns($pronouns);
        }
    }

    public function getGrammaticalGender()
    {
        return $this->grammaticalGender;
    }

    public function setGrammaticalGender($grammaticalGender)
    {
        $this->grammaticalGender = $grammaticalGender;
    }

    /**
     * @return array<string,Pronouns>|null
     */
    public function getPronouns()
    {
        return $this->pronouns;
    }

    /**
     * @param array<string,Pronouns>|null $pronouns
     */
    public function setPronouns($pronouns)
    {
        $this->pronouns = $pronouns;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"             => $this->getAtType(),
            "grammaticalGender" => $this->getGrammaticalGender(),
            "pronouns"          => $this->getPronouns(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
