<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 *
 * JSContact models Card.members as String[Boolean] where each key is the
 * member Card's uid and each value MUST be true (RFC 9553, Section 2.1.6).
 */
class Member implements JsonSerializable
{
    /** @var string */
    private $uid;

    public function __construct($uid = null)
    {
        if ($uid !== null) {
            $this->uid = $uid;
        }
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public static function fromJson($json)
    {
        // Member is just a uid string, so create directly
        if (is_string($json)) {
            return new self($json);
        }

        if (is_object($json) && isset($json->uid)) {
            return new self($json->uid);
        }

        if (is_array($json) && isset($json['uid'])) {
            return new self($json['uid']);
        }

        return new self();
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->uid;
    }
}
