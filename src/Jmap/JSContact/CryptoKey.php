<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * CryptoKey: cryptographic key material or reference associated with the Card.
 *
 * JSContact RFC 9553, Section 2.6.1 (cryptoKeys) and Section 1.4.4 (Resource).
 */
class CryptoKey extends TypeableEntity implements JsonSerializable
{
    /**
     * kind: String (optional).
     *
     * Note: RFC 9553 defines CryptoKey as a Resource; the Resource "kind" values are
     * defined by the property using it.
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

    /**
     * data: String (optional).
     * Embedded key data (e.g., an armored public key).
     *
     * @var string|null
     */
    private $data;

    public function __construct()
    {
        $this->setAtType('CryptoKey');
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

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
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
            "data"      => $this->getData(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
