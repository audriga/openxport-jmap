<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

/**
 * Wrapper for JSCalendar keywords: String[Boolean].
 *
 * Per RFC 8984 Section 4.2.9, keywords is a set of keywords/tags
 * represented as a map where keys are the keywords and values MUST be true.
 *
 * Internally stored as array<string,bool>.
 */
class Keyword implements JsonSerializable
{
    /** @var array<string,bool> */
    private $values = [];

    /**
     * @param array<string,bool> $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $key => $val) {
            if ($val === true) {
                $this->values[$key] = true;
            }
        }
    }

    /**
     * @return array<string,bool>
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Add a keyword to the set.
     * Per RFC 8984, the value is always true.
     *
     * @param string $keyword
     */
    public function set($keyword)
    {
        $this->values[$keyword] = true;
    }

    /**
     * Remove a keyword from the set.
     *
     * @param string $keyword
     */
    public function remove($keyword)
    {
        unset($this->values[$keyword]);
    }

    /**
     * Check if a keyword exists in the set.
     *
     * @param string $keyword
     * @return bool
     */
    public function has($keyword)
    {
        return isset($this->values[$keyword]);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) $this->values;
    }

    /**
     * @param mixed $json
     *
     * @return Keyword
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }
        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        $values = [];
        foreach ((array) $json as $key => $val) {
            // Per RFC 8984, only accept true values
            if ($val === true) {
                $values[$key] = true;
            }
        }

        return new self($values);
    }
}
