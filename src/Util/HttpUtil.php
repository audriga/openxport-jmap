<?php

namespace OpenXPort\Util;

/**
 * Util functions for HTTP-related things
 */
class HttpUtil
{
    /**
     * Parse the input and return a Request Object
     *
     * @return OpenXPort\Jmap\Core\Request A JMAP Request Object
     */
    public static function getRequestBody()
    {
        if (strcmp($_SERVER['REQUEST_METHOD'], "POST") === 0) {
            $jsonBody = json_decode(file_get_contents('php://input'));
            return new \OpenXPort\Jmap\Core\Request($jsonBody);
        }

        return;
    }
}
