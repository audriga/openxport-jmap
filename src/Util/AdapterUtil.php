<?php

namespace OpenXPort\Util;

use OpenXPort\Util\Logger;

/**
 * The class AdapterUtil is a class,
 * containing utility functions that can be
 * helpful to use within various data adapters,
 * implemented for JMAP support for webmailers.
 */
class AdapterUtil
{
    private static $logger;
    private static $encoding = "";
    private static $encodingCallback = null;

    /**
     * Set a function that gets called to handle JSON encoding errors.
     * Some webmailers do some encoding magic. We may need to run webmailer-specific code after failed JSON encoding.
     *
     * @param callable $callback a function that will return a string which defines the encoding
     */
    public static function setEncodingCallback($callback)
    {
        self::$encodingCallback = $callback;
    }

    /**
     * Set some parameters used for handling JSON encoding errors via a callback.
     * Currently only sets $encoding to the encoding used by the current user.
     */
    public static function executeEncodingCallback()
    {
        $logger = Logger::getInstance();

        if (self::$encodingCallback) {
            $cb_values = call_user_func(self::$encodingCallback);
            self::$encoding = $cb_values["encoding"];
            $logger->info("Using encoding: " . print_r(self::$encoding, true));

            return;
        }
        $logger->notice("No JSON encoding callback set.");
    }

    /**
     * Checks whether the supplied data is set
     * and is not null.
     *
     * @param mixed $data The data to check
     * @return boolean Return true if the data is set and not null. Otherwise, return false
     */
    public static function isSetAndNotNull($data)
    {
        return (isset($data) && !is_null($data));
    }

    /**
     * Checks whether the supplied data is set, not null and not empty.
     *
     * @param mixed $data The data to check
     * @return boolean Return true if the data is set, not null and not empty. Otherwise, return false
     */
    public static function isSetNotNullAndNotEmpty($data)
    {
        return (isset($data) && !is_null($data) && !empty($data));
    }

    /**
     * Parses a datetime string according to a given format and
     * formats it according to another given format.
     *
     * @param string $dateTime The datetime string to parse
     * @param string $inputDateFormat The format, according to which we want to parse the datetime string
     * @param string $ouputDateFormat The format, according to which we want to format the parsed datetime string
     * @param string|null $alternativeInputDateFormat An optional alternative input format to use for parsing
     * @return string|null Returns a datetime string in the specified output format or null if parsing failed
     */
    public static function parseDateTime(
        $dateTime,
        $inputDateFormat,
        $outputDateFormat,
        $alternativeInputDateFormat = null
    ) {
        // Check if the datetime string is set, not null and not empty
        if (self::isSetAndNotNull($dateTime) && !empty($dateTime)) {
            // Try to parse it with the initial input format
            $dateObject = \DateTime::createFromFormat($inputDateFormat, $dateTime);

            // If initial parsing failed and we have an alternative format, try parsing with the alternative format
            if ($dateObject === false && !is_null($alternativeInputDateFormat)) {
                $dateObject = \DateTime::createFromFormat($alternativeInputDateFormat, $dateTime);

                // If parsing failed with the alternative format, return null
                if ($dateObject === false) {
                    self::$logger = Logger::getInstance();
                    self::$logger->error("Parsing of datetime " . $dateTime . " failed");
                    return null;
                }
            }

            // Format the parsed date according to the output format
            $dateString = date_format($dateObject, $outputDateFormat);

            return $dateString;
        }

        // Return null if the supplied datetime string is not set, null or empty
        return null;
    }

    /**
     * Does some initial HTML entity encoding (before reencode()).
     * @param string|null input string
     * @return string|null decoded string. Null if input == null.
     */
    public static function decodeHtml($str)
    {
        if (!$str) {
            return null;
        }

        return str_replace("<br>", "\n", $str);
    }

    /**
     * Converts to UTF-8, then decodes HTML:
     * * takes configured encoding for account, tries to auto-detect if unavailable
     * * ignores broken UTF-8 chars in case of exception or failure.
     *
     * @param string|null input string
     * @return string|null UTF-8 encoded string. Null if input == null.
     */
    public static function reencode($str)
    {
        if (!$str) {
            return null;
        }

        $logger = Logger::getInstance();
        $encoding = "";

        if (self::$encoding) {
            $encoding = self::$encoding;
        } else {
            $encoding = mb_detect_encoding($str, "UTF-8,ISO-8859-1");
            $logger->debug("Auto-detected encoding " . print_r($encoding, true));
        }

        $strCon = iconv($encoding, 'UTF-8', $str);

        if ($strCon) {
            return html_entity_decode($strCon);
        } else {
            throw new \InvalidArgumentException(
                "Unable to convert the following chars from " . $encoding . " to UTF-8: " . print_r($str, true)
            );
        }
    }


    /** helper function to call sanitizeFreeText on an array
     */
    public static function sanitizeJson($value, $key)
    {
        $value->sanitizeFreeText();
    }

    /**
     * Checks if a given vCard object has any children (i.e., components or properties)
     *
     * @param VObject\Component\VCard|null $vCard The vCard object to check
     * @return boolean Returns true iff the vCard object is not null and has at least one child
     */
    public static function checkVCardChildren($vCard)
    {
        if (!isset($vCard)) {
            return false;
        }

        $vCardChildren = $vCard->children();

        if (!isset($vCardChildren) || empty($vCardChildren)) {
            return false;
        }

        return true;
    }
}
