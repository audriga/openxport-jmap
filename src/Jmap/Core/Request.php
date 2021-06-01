<?php

namespace Jmap\Core;

class Request {

    private $using;
    private $methodCalls;
    private $createdIds;

    public function __construct($using, $methodCalls, $createdIds = []) {
        $this->using = $using;

        // Transform method calls to Invocation objects
        $this->methodCalls = \array_map(function ($methodCall) {
            return new Invocation($methodCall[0], (array) $methodCall[1], $methodCall[2]);
        }, $methodCalls);

        $this->createdIds = $createdIds;
    }

    public function getCapabilities() {
        return $this->using;
    }

    public function getMethodCalls() {
        return $this->methodCalls;
    }

    public function getCreatedIds() {
        return $this->createdIds;
    }

}