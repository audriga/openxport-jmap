<?php

namespace OpenXPort\Util;

/**
 * Logger that discards everything, used as a fallback when no logger is configured.
 */
class NullLogger extends AbstractSimpleLogger
{
    public function log($level, $message, array $context = array())
    {
    }
}
