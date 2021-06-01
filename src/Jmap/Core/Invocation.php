<?php

namespace Jmap\Core;

use JsonSerializable;

class Invocation implements JsonSerializable {

    private $name;
    private $arguments;
    private $methodCallId;

    public function __construct($name, $arguments, $methodCallId) {
        $this->name = $name;
        $this->arguments = $arguments;
        $this->methodCallId = $methodCallId;
    }

    public function getName() {
        return $this->name;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function getMethodCallId() {
        return $this->methodCallId;
    }

    public function jsonSerialize() {
        return [$this->getName(), $this->getArguments(), $this->getMethodCallId()];
    }

}