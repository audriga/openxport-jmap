<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * Link: link (e.g., contact URI) associated with the Card.
 *
 * JSContact RFC 9553, Section 2.6.3 (links) and Section 1.4.4 (Resource).
 */
class Link extends TypeableEntity implements JsonSerializable
{
    /**
     * kind: String (optional).
     * Enum: contact.
     *
     * @var string|null
     */
    private $kind;

    /**
     * uri: String (mandatory).
     *
     * @var string
     */
    private $uri;

    /**
     * mediaType: String (optional).
     *
     * @var string|null
     */
    private $mediaType;

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
        $uri = null,
        $kind = null,
        $mediaType = null,
        $contexts = null,
        $pref = null,
        $label = null
    ) {
        $this->setAtType('Link');

        $this->setUri($uri);

        if ($kind !== null) {
            $this->setKind($kind);
        }
        if ($mediaType !== null) {
            $this->setMediaType($mediaType);
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

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }

    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
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

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

        $instance = new self();

        if (isset($json->kind)) {
            $instance->setKind($json->kind);
        }
        if (isset($json->uri)) {
            $instance->setUri($json->uri);
        }
        if (isset($json->mediaType)) {
            $instance->setMediaType($json->mediaType);
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
            "@type"     => $this->getAtType(),
            "kind"      => $this->getKind(),
            "uri"       => $this->getUri(),
            "mediaType" => $this->getMediaType(),
            "contexts"  => $this->getContexts(),
            "pref"      => $this->getPref(),
            "label"     => $this->getLabel(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
