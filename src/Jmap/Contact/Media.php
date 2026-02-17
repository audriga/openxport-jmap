<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

/**
 * Media: resource such as photo, logo, or sound associated with the Card.
 *
 * JSContact RFC 9553, Section 2.6.4 (Media) and Section 1.4.4 (Resource).
 * JMAP Contacts adds optional blobId for media stored as a Blob.
 */
class Media extends TypeableEntity implements JsonSerializable
{
    /**
     * kind: String (mandatory).
     * Enum: photo | sound | logo.
     *
     * @var string
     */
    private $kind;

    /**
     * uri: String (optional in JMAP context when blobId is used, otherwise mandatory Resource.uri).
     *
     * @var string|null
     */
    private $uri;

    /**
     * mediaType: String (optional).
     * The media type (MIME type) of the resource, e.g. "image/jpeg".
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
     * blobId: Id (optional, JMAP Contacts extension).
     * Id of the Blob representing the binary contents of the resource.
     *
     * @var string|null
     */
    private $blobId;

    public function __construct()
    {
        // @type MUST be "Media" if set.
        $this->setAtType('Media');
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

    public function getBlobId()
    {
        return $this->blobId;
    }

    public function setBlobId($blobId)
    {
        $this->blobId = $blobId;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"     => $this->getAtType(),   // MUST be "Media" if present.
            "kind"      => $this->getKind(),
            "uri"       => $this->getUri(),
            "mediaType" => $this->getMediaType(),
            "contexts"  => $this->getContexts(),
            "pref"      => $this->getPref(),
            "label"     => $this->getLabel(),
            "blobId"    => $this->getBlobId(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
