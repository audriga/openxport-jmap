<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class OnlineService extends TypeableEntity implements JsonSerializable
{
    /** @var string $user (mandatory) */
    private $user;

    /** @var string $type (mandatory) */
    private $type;

    /** @var string $service (optional)
     *  This SHOULD be the canonical service name including capitalization. Examples are GitHub, kakao, Mastodon.
     * */
    private $service;

    /** @var array<string, boolean> $contexts (optional)
     * The string keys of the array are of type Context
     * (see https://www.ietf.org/archive/id/draft-ietf-calext-jscontact-07.html#section-2.3.2-3.5)
     */
    private $contexts;

    /** @var int $pref (optional)
     * The int here is the Preference type
     * (see https://www.ietf.org/archive/id/draft-ietf-calext-jscontact-07.html#section-2.3.2-3.6)
     */
    private $pref;

    /** @var string $label (optional) */
    private $label;

    public function __construct($user, $type)
    {
        $this->user = $user;
        $this->type = $type;
        $this->atType = "OnlineService";
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;
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
            "user" => $this->getUser(),
            "type" => $this->getType(),
            "service" => $this->getService(),
            "contexts" => $this->getContexts(),
            "pref" => $this->getPref(),
            "label" => $this->getLabel()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
