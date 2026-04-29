<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * Keywords: helper for `keywords: String[Boolean]`.
 *
 * Each key is a free-text keyword (tag); each value is always true.
 */
class Keywords implements JsonSerializable
{
    /**
     * @var array<string,bool>
     */
    private $items = [];

    /**
     * @param array<string,bool> $items
     */
    public function __construct($items = null)
    {
        $this->items = [];

        if ($items === null) {
            return;
        }

        foreach ($items as $keyword => $flag) {
            if ($flag) {
                $this->items[$keyword] = true;
            }
        }
    }

    /**
     * @return array<string,bool>
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Replace the full keyword set.
     *
     * @param array<string,bool> $items
     */
    public function setAll(array $items)
    {
        $this->items = [];
        foreach ($items as $keyword => $flag) {
            if ($flag) {
                $this->items[$keyword] = true;
            }
        }
    }

    /**
     * Add or enable a keyword.
     *
     * @param string $keyword
     */
    public function add($keyword)
    {
        $this->items[$keyword] = true;
    }

    /**
     * Remove a keyword.
     *
     * @param string $keyword
     */
    public function remove($keyword)
    {
        unset($this->items[$keyword]);
    }

    public function has($keyword)
    {
        return isset($this->items[$keyword]);
    }

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }

    // Convert to array if it's an object
        if (is_object($json)) {
            $json = (array) $json;
        }

    // Keywords is just a map of keyword => true
        return new self($json);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) $this->items;
    }
}
