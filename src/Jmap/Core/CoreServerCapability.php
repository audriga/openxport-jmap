<?php

namespace OpenXPort\Jmap\Core;

class CoreServerCapability extends ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array(
            'maxSizeUpload' => 50000000,
            'maxConcurrentUpload' => 4,
            'maxSizeRequest' => 10000000,
            'maxConcurrentRequests' => 4,
            'maxCallsInRequest' => 16,
            'maxObjectsInGet' => 500,
            'maxObjectsInSet' => 500,
            'collationAlgorithms' => []
        );
        $this->name = "urn:ietf:params:jmap:core";
    }

    public function getMethods()
    {
        return array(
            "Core/echo" => Methods\CoreEchoMethod::class,
        );
    }
}
