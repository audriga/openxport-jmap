<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class File extends TypeableEntity implements JsonSerializable
{
    /** @var string $href (mandatory) */
    private $href;

    /** @var string $mediaType (optional) */
    private $mediaType;

    /** @var int $size (optional) */
    private $size;

    /** @var int $pref (optional)
     * The int here is the Preference type
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.4)
     */
    private $pref;

    /** @var string $label (optional) */
    private $label;

    public function getHref()
    {
        return $this->href;
    }

    public function setHref($href)
    {
        $this->href = $href;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }

    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
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
            "href" => $this->getHref(),
            "mediaType" => $this->getMediaType(),
            "size" => $this->getSize(),
            "pref" => $this->getPref(),
            "label" => $this->getLabel()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
