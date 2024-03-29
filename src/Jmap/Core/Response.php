<?php

namespace OpenXPort\Jmap\Core;

use JsonSerializable;

class Response implements JsonSerializable
{
    private $methodResponses;

    public function __construct($methodResponses, $session)
    {
        $this->session = $session;
        $this->methodResponses = $methodResponses;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $res = [
            "methodResponses" => $this->methodResponses,
            "sessionState" => $this->session->getState()
        ];

        $logger = \OpenXPort\Util\Logger::getInstance();

        if ($logger instanceof \OpenXPort\Util\ArrayLogger) {
            $res["logs"] = $logger->getEntries();
        }

        return (object) array_filter($res, function ($val) {
            return !is_null($val);
        });
    }
}
