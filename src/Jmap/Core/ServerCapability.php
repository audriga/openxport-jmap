<?php

namespace OpenXPort\Jmap\Core;

/**
 * Each Server capability is attached to a Session.
 * Its main purpose is to provide information about the server's capabilities
 */
abstract class ServerCapability extends Capability
{
    /**
     * Get an array of methods provided by this capability
     *
     * The values are fully qualified class names to be instantiated later.
     *
     * @see https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class
     * @example
     *   public function getMethods()
     *   {
     *     return array(
     *       "Core/echo" => CoreCapability\CoreType\CoreEchoMethod::class,
     *     );
     *   }
     *
     * @return array<string, class-string>
     */
    abstract public function getMethods();
}
