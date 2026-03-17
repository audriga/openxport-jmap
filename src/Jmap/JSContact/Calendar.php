<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * Calendar class represents a calendar resource in JSContact.
 *
 * Based on RFC 9553 Section 2.4.1
 *
 * A Calendar object represents a calendar associated with the entity
 * represented by this card.
 */
class Calendar implements JsonSerializable
{
    /**
     * @var string The kind of calendar. Valid values are:
     *             - "calendar": A calendar for events
     *             - "freeBusy": A free-busy URL
     */
    private $kind;

    /**
     * @var string The URI to access the calendar
     */
    private $uri;

    /**
     * @var string|null The media type of the resource
     */
    private $mediaType;

    /**
     * @var array<string, bool>|null The contexts in which this calendar is used
     *                                Keys: "private" or "work", Values: true
     */
    private $contexts;

    /**
     * @var int|null The preference level (lower values = higher preference)
     */
    private $pref;

    /**
     * @var string|null User-defined label for this calendar
     */
    private $label;

    /**
     * Constructor
     *
     * @param string|null $kind The kind of calendar (calendar or freeBusy)
     */
    public function __construct($kind = null)
    {
        $this->kind = $kind;
        $this->uri = null;
        $this->mediaType = null;
        $this->contexts = null;
        $this->pref = null;
        $this->label = null;
    }

    /**
     * Get the kind of calendar
     *
     * @return string|null
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Set the kind of calendar
     *
     * @param string $kind The kind (calendar or freeBusy)
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    /**
     * Get the URI
     *
     * @return string|null
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set the URI
     *
     * @param string $uri The URI to access the calendar
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Get the media type
     *
     * @return string|null
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Set the media type
     *
     * @param string|null $mediaType The media type
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
    }

    /**
     * Get the contexts
     *
     * @return array<string, bool>|null
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * Set the contexts
     *
     * @param array<string, bool>|null $contexts The contexts (private/work)
     */
    public function setContexts($contexts)
    {
        $this->contexts = $contexts;
    }

    /**
     * Get the preference level
     *
     * @return int|null
     */
    public function getPref()
    {
        return $this->pref;
    }

    /**
     * Set the preference level
     *
     * @param int|null $pref The preference (lower = higher preference)
     */
    public function setPref($pref)
    {
        $this->pref = $pref;
    }

    /**
     * Get the label
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the label
     *
     * @param string|null $label User-defined label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $result = [];

        if ($this->kind !== null) {
            $result['kind'] = $this->kind;
        }

        if ($this->uri !== null) {
            $result['uri'] = $this->uri;
        }

        if ($this->mediaType !== null) {
            $result['mediaType'] = $this->mediaType;
        }

        if ($this->contexts !== null) {
            $result['contexts'] = (object) $this->contexts;
        }

        if ($this->pref !== null) {
            $result['pref'] = $this->pref;
        }

        if ($this->label !== null) {
            $result['label'] = $this->label;
        }

        return (object) $result;
    }
}
