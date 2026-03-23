<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * Directory: a directory or directory entry containing information about the entity.
 *
 * JSContact RFC 9553, Section 2.6.2 (directories) and Section 1.4.4 (Resource).
 */
class Directory extends TypeableEntity implements JsonSerializable
{
    private $type = 'Directory';
    /**
     * kind: String (mandatory).
     * Enum: directory | entry.
     *
     * @var string
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
     * serviceType: String (optional).
     * The type of directory service.
     *
     * @var string|null
     */
    private $serviceType;

        /**
     * listAs: UnsignedInt (optional).
     * The position of this directory in a list of directories.
     *
     * @var int|null
     */
    private $listAs;


    public function __construct(
        $kind,
        $uri,
        $mediaType = null,
        $contexts = null,
        $pref = null,
        $label = null,
        $serviceType = null,
        $listAs = null
    ) {
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
        if ($serviceType !== null) {
            $this->setServiceType($serviceType);
        }
        if ($listAs !== null) {
            $this->setListAs($listAs);
        }
    }

    public function getListAs()
    {
        return $this->listAs;
    }

    public function setListAs($listAs)
    {
        $this->listAs = $listAs;
    }

    public function getType()
    {
        return $this->type;
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

    public function getServiceType()
    {
        return $this->serviceType;
    }

    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"       => $this->getAtType(),
            "kind"        => $this->getKind(),
            "uri"         => $this->getUri(),
            "mediaType"   => $this->getMediaType(),
            "contexts"    => $this->getContexts(),
            "pref"        => $this->getPref(),
            "label"       => $this->getLabel(),
            "serviceType" => $this->getServiceType(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
