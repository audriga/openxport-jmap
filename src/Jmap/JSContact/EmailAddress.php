<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class EmailAddress extends TypeableEntity implements JsonSerializable
{
    /** @var string $email (optional) */
    private $email;

    /** @var array<string, boolean> $contexts (optional)
     * The string keys of the array are of type Context
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.1)
     */
    private $contexts;

    /** @var int $pref (optional)
     * The int here is the Preference type
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.4)
     */
    private $pref;

    /** @var string $label (optional) */
    private $label;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
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

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "email" => $this->getEmail(),
            "contexts" => $this->getContexts(),
            "pref" => $this->getPref(),
            "label" => $this->getLabel()
        ];
    }
}
