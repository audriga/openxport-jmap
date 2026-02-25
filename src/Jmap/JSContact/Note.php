<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * JSContact Note object as defined in RFC 9553 §2.8.3.
 *
 * Part of Card.notes: Id[Note].
 */
class Note extends TypeableEntity implements JsonSerializable
{
    /** @var string */
    private $note;

    /** @var string|null UTCDateTime, e.g. "2022-11-23T15:01:32Z" */
    private $created;

    /** @var Author|null */
    private $author;

    public function __construct()
    {
        $this->setAtType('Note');
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author = null)
    {
        $this->author = $author;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            '@type'   => $this->getAtType(),
            'note'    => $this->getNote(),
            'created' => $this->getCreated(),
            'author'  => $this->getAuthor(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
