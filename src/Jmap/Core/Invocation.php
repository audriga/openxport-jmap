<?php

namespace OpenXPort\Jmap\Core;

use JsonSerializable;

class Invocation implements JsonSerializable
{
    private $name;
    private $arguments;
    private $methodCallId;

    public function __construct($name, $arguments, $methodCallId)
    {
        $this->name = $name;
        $this->arguments = $arguments;
        $this->methodCallId = $methodCallId;
    }

    public static function fromJson($methodCallJson)
    {
        $name = $methodCallJson[0];
        $arguments = (array) $methodCallJson[1];
        $methodCallId = $methodCallJson[2];

        if (is_null($name) || empty($name)) {
            die(ErrorHandler::raiseNotRequest());
        }

        if (is_null($methodCallId)) {
            die(ErrorHandler::raiseNotRequest());
        }

        return new self($name, $arguments, $methodCallId);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function getMethodCallId()
    {
        return $this->methodCallId;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $arguments = array_filter(
            $this->arguments,
            function ($val) {
                return !empty($val);
            }
        );
        return [$this->getName(), $arguments, $this->getMethodCallId()];
    }
}
