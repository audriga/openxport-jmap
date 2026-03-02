<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * SchedulingAddress: scheduling addresses (e.g., CALADRURI) associated with the Card.
 *
 * JSContact RFC 9553, Section 2.4.2 (schedulingAddresses).
 */
class SchedulingAddress extends TypeableEntity implements JsonSerializable
{
    /**
     * kind: String (mandatory).
     * Enum: calendar | freeBusy.
     *
     * @var string
     */
    private $kind;

    /**
     * uri: String (mandatory).
     * A URI identifying the scheduling address.
     *
     * @var string
     */
    private $uri;

    /**
     * mediaType: String (optional).
     * The media type (MIME type) of the resource identified by uri, e.g. "text/calendar".
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
        $kind = null,
        $uri = null,
        $mediaType = null,
        $contexts = null,
        $pref = null,
        $label = null
    ) {
        $this->setAtType('SchedulingAddress');

        $this->setKind($kind);
        $this->setUri($uri);

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
