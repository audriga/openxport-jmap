<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class ContactLanguage extends TypeableEntity implements JsonSerializable
{
    /** @var string $context (optional)
     * The string here is the Context type
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.1)
     */
    private $context;

    /** @var int $pref (optional)
     * The int here is the Preference type
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.4)
     */
    private $pref;

    public function getContext()
    {
        return $this->context;
    }

    public function setContext($context)
    {
        $this->context = $context;
    }

    public function getPref()
    {
        return $this->pref;
    }

    public function setPref($pref)
    {
        $this->pref = $pref;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "context" => $this->getContext(),
            "pref" => $this->getPref()
        ];
    }
}
