<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

/**
 * Wrapper for JSCalendar keywords: String[Boolean].
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
        $this->values = $values;
    }

    /**
     * @return array<string,bool>
     */
    public function getValues()
    {
        return $this->values;
    }

    public function set($keyword, $present = true)
    {
        $this->values[$keyword] = $present;
    }

    public function remove($keyword)
    {
        unset($this->values[$keyword]);
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
            $values[$key] = (bool) $val;
        }

        return new self($values);
    }
}
