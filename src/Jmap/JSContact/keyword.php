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
    public function __construct(array $items = [])
    {
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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) $this->items;
    }
}
