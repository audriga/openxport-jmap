<?php

namespace OpenXPort\Jmap\Preferences;

use JsonSerializable;

class Forward implements JsonSerializable
{
    /** @var bool $isEnabled */
    private $isEnabled;

    /** @var string|null $forwardAction */
    private $forwardAction;

    /** @var string|null $forwardTo */
    private $forwardTo;

    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    public function getForwardAction()
    {
        return $this->forwardAction;
    }

    public function setForwardAction($forwardAction)
    {
        $this->forwardAction = $forwardAction;
    }

    public function getForwardTo()
    {
        return $this->forwardTo;
    }

    public function setForwardTo($forwardTo)
    {
        $this->forwardTo = $forwardTo;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "isEnabled" => $this->getIsEnabled(),
            "forwardAction" => $this->getForwardAction(),
            "forwardTo" => $this->getForwardTo()
        ];
    }
}
