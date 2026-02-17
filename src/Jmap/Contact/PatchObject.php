<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;

/**
 * PatchObject: a set of JSON Patches scoped to a Card, used for localizations.
 *
 * Keys are JSON Pointer–like paths relative to the Card; values are any
 * valid JSContact value for the targeted property. RFC 9553, Section 2.7.1.
 */
class PatchObject implements JsonSerializable
{
    /**
     * patches: String[Any].
     * Key: path relative to the Card (e.g. "name", "titles/t1/name").
     * Value: localized value to apply at that path.
     *
     * @var array<string,mixed>
     */
    private $patches = [];

    public function __construct(array $patches = [])
    {
        $this->patches = $patches;
    }

    /**
     * @return array<string,mixed>
     */
    public function getPatches()
    {
        return $this->patches;
    }

    /**
     * @param array<string,mixed> $patches
     */
    public function setPatches($patches)
    {
        $this->patches = $patches;
    }

    /**
     * Add or overwrite a single patch entry.
     *
     * @param string $path
     * @param mixed  $value
     */
    public function set($path, $value)
    {
        $this->patches[$path] = $value;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        // PatchObject is just serialized as the raw map.
        return (object) $this->patches;
    }
}
