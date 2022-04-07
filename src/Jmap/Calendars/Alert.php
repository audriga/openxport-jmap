<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class Alert implements JsonSerializable
{
    private $type;
    private $trigger;
    private $acknowledged;
    private $relatedTo;
    private $action;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getTrigger()
    {
        return $this->trigger;
    }

    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;
    }

    public function getAcknowledged()
    {
        return $this->acknowledged;
    }

    public function setAcknowledged($acknowledged)
    {
        $this->acknowledged = $acknowledged;
    }

    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "trigger" => $this->getTrigger(),
            "acknowledged" => $this->getAcknowledged(),
            "relatedTo" => $this->getRelatedTo(),
            "action" => $this->getAction()
        ];
    }
}
