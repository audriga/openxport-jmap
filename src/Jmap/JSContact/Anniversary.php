<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Anniversary extends TypeableEntity implements JsonSerializable
{
    /**
     * kind: String (mandatory).
     * Enum: birth | death | wedding.
     *
     * @var string
     */
    private $kind;

    /**
     * date: PartialDate|Timestamp (mandatory).
     * Either a PartialDate object (year/month/day) or a Timestamp object.
     *
     * @var mixed
     */
    private $date;

    /**
     * place: Address (optional).
     *
     * @var Address|null
     */
    private $place;

    /** @var string|null */
    private $label;

    public function __construct($kind = null, $date = null, $place = null, $label = null)
    {
        $this->setAtType('Anniversary');

        if ($kind !== null) {
            $this->setKind($kind);
        }
        if ($date !== null) {
            $this->setDate($date);
        }

        if ($place !== null) {
            $this->setPlace($place);
        }
        if ($label !== null) {
            $this->setLabel($label);
        }
    }
    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function setPlace($place)
    {
        $this->place = $place;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getAtType(),
            "kind"  => $this->getKind(),
            "date"  => $this->getDate(),
            "place" => $this->getPlace(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
