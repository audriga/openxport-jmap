<?php

namespace OpenXPort\Util;

abstract class SessionUtil
{
    /**
     * Abstract static function for creating a JMAP session object
     *
     * Takes non-JMAP account data and converts it to JMAP account data,
     * which in turn is put in the returned JMAP session object.
     *
     * @param array $accountData
     * @return \OpenXPort\Jmap\Core\Session
     */
    abstract public static function createSession($accountData);
}
