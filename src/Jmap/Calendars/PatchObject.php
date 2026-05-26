<?php

namespace OpenXPort\Jmap\Calendar;

use OpenXPort\Util\AdapterUtil;
use JsonSerializable;

/**
 * Represents a patch object for recurrence overrides in JSCalendar events.
 */
class PatchObject implements JsonSerializable
{
    private $properties = [];

    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    /**
     * Get a property value dynamically.
     */
    public function __get($name)
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * Set a property value dynamically.
     */
    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    /**
     * Get all properties.
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set a specific property by path.
     */
    public function setProperty($path, $value)
    {
        $this->properties[$path] = $value;
    }

    /**
     * Get a specific property by path.
     */
    public function getProperty($path)
    {
        return $this->properties[$path] ?? null;
    }

    /**
     * Check if a property exists.
     */
    public function hasProperty($path)
    {
        return isset($this->properties[$path]);
    }

    /**
     * Remove a property.
     */
    public function removeProperty($path)
    {
        unset($this->properties[$path]);
    }

    /**
     * Get the excluded flag.
     */
    public function getExcluded()
    {
        return $this->properties['excluded'] ?? null;
    }

    /**
     * Set the excluded flag.
     */
    public function setExcluded($excluded)
    {
        $this->properties['excluded'] = $excluded;
    }

    /**
     * Check if this occurrence is excluded.
     */
    public function isExcluded()
    {
        return $this->getExcluded() === true;
    }

    /**
     * Get alerts, converting from JSON if needed.
     */
    public function getAlerts()
    {
        $alerts = $this->properties['alerts'] ?? null;
        if (is_null($alerts)) {
            return null;
        }

        if ($alerts instanceof \stdClass) {
            $alerts = (array) $alerts;
        }

        if (!is_array($alerts)) {
            return ($alerts instanceof Alert) ? $alerts : null;
        }

        $allAreAlerts = true;
        foreach ($alerts as $alert) {
            if (!($alert instanceof Alert)) {
                $allAreAlerts = false;
                break;
            }
        }

        if ($allAreAlerts) {
            return $alerts;
        }

        $convertedAlerts = [];
        foreach ($alerts as $key => $alert) {
            if ($alert instanceof Alert) {
                $convertedAlerts[$key] = $alert;
            } elseif (is_object($alert) || is_array($alert)) {
                $convertedAlerts[$key] = Alert::fromJson($alert);
            }
        }

        return empty($convertedAlerts) ? null : $convertedAlerts;
    }

    /**
     * Set alerts, converting to Alert objects.
     */
    public function setAlerts($alerts)
    {
        if ($alerts instanceof \stdClass) {
            $alerts = (array) $alerts;
        }

        if (is_array($alerts)) {
            $convertedAlerts = [];
            foreach ($alerts as $key => $alert) {
                if ($alert instanceof Alert) {
                    $convertedAlerts[$key] = $alert;
                } elseif (is_object($alert) || is_array($alert)) {
                    $wrappedAlert = [$key => $alert];
                    $parsedAlerts = Alert::fromJson($wrappedAlert);
                    if (isset($parsedAlerts[$key])) {
                        $convertedAlerts[$key] = $parsedAlerts[$key];
                    }
                }
            }
            $this->properties['alerts'] = $convertedAlerts;
        } else {
            $this->properties['alerts'] = $alerts;
        }
    }

    /**
     * Get links, normalizing from JSON.
     */
    public function getLinks()
    {
        $links = $this->properties['links'] ?? null;
        if (is_null($links)) {
            return null;
        }

        if ($links instanceof \stdClass) {
            $links = (array) $links;
        }

        if (!is_array($links)) {
            return null;
        }

        $normalizedLinks = [];
        foreach ($links as $id => $link) {
            $normalizedLink = \OpenXPort\Jmap\Calendar\Link::fromMixed($link);
            if (!is_null($normalizedLink)) {
                $normalizedLinks[$id] = $normalizedLink;
            }
        }
        return $normalizedLinks;
    }

    /**
     * Set links.
     */
    public function setLinks($links)
    {
        $this->properties['links'] = $links;
    }

    /**
     * Handles dynamic property getters and setters.
     */
    public function __call($method, $args)
    {
        if (strpos($method, 'get') === 0) {
            $property = lcfirst(substr($method, 3));
            return $this->properties[$property] ?? null;
        }

        if (strpos($method, 'set') === 0) {
            $property = lcfirst(substr($method, 3));
            $this->properties[$property] = $args[0] ?? null;
            return;
        }

        throw new \BadMethodCallException("Method {$method} does not exist");
    }

    /**
     * Sanitize text fields for encoding issues.
     */
    public function sanitizeFreeText()
    {
        if (isset($this->properties['alerts']) && is_array($this->properties['alerts'])) {
            foreach ($this->properties['alerts'] as $alert) {
                if ($alert instanceof Alert) {
                    $alert->sanitizeFreeText();
                }
            }
        }

        if (isset($this->properties['title'])) {
            $this->properties['title'] = AdapterUtil::reencode($this->properties['title']);
        }
        if (isset($this->properties['description'])) {
            $this->properties['description'] = AdapterUtil::reencode($this->properties['description']);
        }
    }

    /**
     * Check if patch object has no properties set.
     */
    public function isEmpty()
    {
        $checkProps = ['title', 'description', 'created', 'updated', 'sequence', 'start',
                       'duration', 'timeZone', 'keywords', 'locations', 'vLocations',
                       'coordinates', 'url', 'relatedTo', 'virtualLocations', 'freeBusyStatus',
                       'status', 'color', 'priority', 'alerts', 'participants', 'links',
                       'showWithoutTime', 'replyTo', 'requestStatus'];

        foreach ($checkProps as $prop) {
            if ($this->hasProperty($prop)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Serialize to JSON.
     */
    public function jsonSerialize(): mixed
    {
        $props = $this->properties;

        if (isset($props['alerts']) && is_array($props['alerts'])) {
            $serializedAlerts = [];
            foreach ($props['alerts'] as $key => $alert) {
                $serializedAlerts[$key] = ($alert instanceof Alert) ? $alert->jsonSerialize() : $alert;
            }
            $props['alerts'] = $serializedAlerts;
        }

        return (object) $props;
    }

    /**
     * Create from JSON data.
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }
        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        $patchObject = new self((array) $json);

        if (isset($patchObject->properties['alerts'])) {
            $alerts = $patchObject->properties['alerts'];
            if (is_object($alerts) || is_array($alerts)) {
                $patchObject->setAlerts($alerts);
            }
        }

        return $patchObject;
    }
}
