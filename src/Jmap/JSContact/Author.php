<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * JSContact Author object for Note.author (RFC 9553 §2.8.3).
 */
class Author extends TypeableEntity implements JsonSerializable
{
    /** @var string|null */
    private $name;

    /** @var string|null */
    private $uri;

    public function __construct($name = null, $uri = null)
    {
        $this->setAtType('Author');

        if ($name !== null) {
            $this->setName($name);
        }
        if ($uri !== null) {
            $this->setUri($uri);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name = null)
    {
        $this->name = $name;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri = null)
    {
        $this->uri = $uri;
    }

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

        $name = isset($json->name) ? $json->name : null;
        $uri = isset($json->uri) ? $json->uri : null;

        return new self($name, $uri);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            '@type' => $this->getAtType(),
            'name'  => $this->getName(),
            'uri'   => $this->getUri(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
