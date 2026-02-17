<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

/**
 * JSContact Author object for Note.author (RFC 9553 §2.8.3).[web:166]
 */
class Author extends TypeableEntity implements JsonSerializable
{
    /** @var string|null */
    private $name;

    /** @var string|null */
    private $uri;

    public function __construct()
    {
        // @type MUST be "Author", if set.[web:166]
        $this->setAtType('Author');
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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            '@type' => $this->getAtType(), // "Author"
            'name'  => $this->getName(),
            'uri'   => $this->getUri(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
