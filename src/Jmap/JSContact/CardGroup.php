<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * A CardGroup object represents a group of cards.
 * Its members may be Cards or CardGroups.
 *
 * MIME type: application/jscontact+json;type=cardgroup
 *
 * Implemented as per JSContact IETF draft version 09
 * @see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09
 */
class CardGroup extends TypeableEntity implements JsonSerializable
{
    /** @var string $id (mandatory) (This property is not part of the JSContact spec and is added by audriga) */
    private $id;

    /** @var string $uid (mandatory) */
    private $uid;

    /** @var array<string, boolean> $members (mandatory) */
    private $members;

    /** @var string $name (optional) */
    private $name;

    /** @var Card $card (optional) */
    private $card;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function setMembers($members)
    {
        $this->members = $members;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCard()
    {
        return $this->card;
    }

    public function setCard($card)
    {
        $this->card = $card;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getAtType(),
            "id" => $this->getId(),
            "uid" => $this->getUid(),
            "members" => $this->getMembers(),
            "name" => $this->getName(),
            "card" => $this->getCard()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
