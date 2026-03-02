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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->uid;
    }
}
