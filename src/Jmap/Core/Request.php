<?php

namespace OpenXPort\Jmap\Core;

class Request
{
    private $using;
    private $methodCalls;
    private $createdIds;

    public function __construct($requestJson)
    {
        // Read the different parts of the JSON JMAP Request and place them nicely in variables
        // and make sure it is a valid request
        $this->using = $requestJson->using;

        if (!is_array($this->using) || is_null($this->using) || empty($this->using)) {
            // TODO
            die(ErrorHandler::raiseNotRequest());
        }

        $methodCalls = $requestJson->methodCalls;

        if (!is_array($methodCalls) || is_null($methodCalls) || empty($methodCalls)) {
            die(ErrorHandler::raiseNotRequest());
        }

        // Transform method calls to Invocation objects
        $this->methodCalls = array_map(function ($methodCall) {
            return Invocation::fromJson($methodCall);
        }, $methodCalls);

        $this->createdIds = $requestJson->createdIds;
    }

    public function getCapabilities()
    {
        return $this->using;
    }

    public function getMethodCalls()
    {
        return $this->methodCalls;
    }

    public function getCreatedIds()
    {
        return $this->createdIds;
    }
}
