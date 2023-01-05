<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class SpeakToAs extends TypeableEntity implements JsonSerializable
{
    /** @var string $grammaticalGender (optional) */
    private $grammaticalGender;

    /** @var string $pronouns (optional) */
    private $pronouns;

    public function getGrammaticalGender()
    {
        return $this->grammaticalGender;
    }

    public function setGrammaticalGender($grammaticalGender)
    {
        $this->grammaticalGender = $grammaticalGender;
    }

    public function getPronouns()
    {
        return $this->pronouns;
    }

    public function setPronouns($pronouns)
    {
        $this->pronouns = $pronouns;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "grammaticalGender" => $this->getGrammaticalGender(),
            "pronouns" => $this->getPronouns()
        ];
    }
}
