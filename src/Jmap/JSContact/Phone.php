<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Phone extends TypeableEntity implements JsonSerializable
{
    /** @var string $phone (mandatory) */
    private $phone;

    /** @var array<string, boolean> $features (optional) */
    private $features;

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

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function setFeatures($features)
    {
        $this->features = $features;
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
        return (object) array_filter([
            "@type" => $this->getAtType(),
            "phone" => $this->getPhone(),
            "features" => $this->getFeatures(),
            "contexts" => $this->getContexts(),
            "pref" => $this->getPref(),
            "label" => $this->getLabel()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
