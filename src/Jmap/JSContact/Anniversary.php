<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Anniversary extends TypeableEntity implements JsonSerializable
{
    /** @var string $type (optional) */
    private $type;

    /** @var string $date (mandatory)
     * The date of this anniversary, in the form "YYYY-MM-DD"
     * (any part may be all 0s for unknown)
     * or a [RFC3339] timestamp.
    */
    private $date;

    /** @var Address $place (optional) */
    private $place;

    /** @var string $label (optional) */
    private $label;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
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

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getAtType(),
            "type" => $this->getType(),
            "date" => $this->getDate(),
            "place" => $this->getPlace(),
            "label" => $this->getLabel()
        ];
    }
}
