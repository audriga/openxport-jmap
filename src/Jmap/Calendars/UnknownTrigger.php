<?php

namespace Jmap\Calendar;

use JsonSerializable;

class UnknownTrigger implements JsonSerializable {

    private $type;

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function jsonSerialize() {
        return (object)[
            "@type" => $this->getType()
        ];
    }

}