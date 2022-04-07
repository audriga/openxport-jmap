<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Resource extends TypeableEntity implements JsonSerializable
{
    /** @var string $resource (mandatory) */
    private $resource;

    /** @var string $type (optional) */
    private $type;

    /** @var string @mediaType (optional) */
    private $mediaType;

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

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }

    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
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

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "resource" => $this->getResource(),
            "type" => $this->getType(),
            "mediaType" => $this->getMediaType(),
            "contexts" => $this->getContexts(),
            "pref" => $this->getPref(),
            "label" => $this->getLabel()
        ];
    }
}
