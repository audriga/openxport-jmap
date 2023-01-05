<?php

namespace OpenXPort\Jmap\Core;

use JsonSerializable;

/**
 * Abstract class to implement a JMAP capability
 *
 * Capabilities are used to extend the functionality of a JMAP server.
 * It consists of Types that provide Methods. For example, a capability
 * of type "urn:ietf:params:jmap:mail" may have a type called "Mailbox" with
 * a corresponding method called "get".
 *
 */
abstract class Capability implements JsonSerializable
{
    /** @var array<string, mixed> */
    protected $capabilities;

    protected $name;

    /**
     * Get capabilities to be used within the JMAP Session Resource to give
     * further information about the server's capabilities in relation to
     * this capability for an account.
     *
     * @see https://tools.ietf.org/html/rfc8620#section-2
     * @return object
     */
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * Get the capability identifier
     *
     * @return string Capability identifier, e.g. urn:ietf:params:jmap:core
     */
    public function getName()
    {
        return $this->name;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) $this->getCapabilities();
    }
}
