<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class OnlineService extends TypeableEntity implements JsonSerializable
{
    /**
     * service: String (optional).
     *
     * @var string|null
     */
    private $service;

    /**
     * uri: String (optional).
     * MUST be a URI as per RFC 3986.
     *
     * @var string|null
     */
    private $uri;

    /**
     * user: String (optional).
     *
     * @var string|null
     */
    private $user;

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

    /**
     * label: String (optional).
     *
     * @var string|null
     */
    private $label;

    public function __construct(
        $service = null,
        $uri = null,
        $user = null,
        $contexts = null,
        $pref = null,
        $label = null
    ) {
        $this->setAtType('OnlineService');

        if ($service !== null) {
            $this->setService($service);
        }
        if ($uri !== null) {
            $this->setUri($uri);
        }
        if ($user !== null) {
            $this->setUser($user);
        }
        if ($contexts !== null) {
            $this->setContexts($contexts);
        }
        if ($pref !== null) {
            $this->setPref($pref);
        }
        if ($label !== null) {
            $this->setLabel($label);
        }
    }

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
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
            "@type"    => $this->getAtType(),
            "service"  => $this->getService(),
            "uri"      => $this->getUri(),
            "user"     => $this->getUser(),
            "contexts" => $this->getContexts(),
            "pref"     => $this->getPref(),
            "label"    => $this->getLabel(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
