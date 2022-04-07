<?php

namespace OpenXPort\Jmap\Core\Methods;

class CoreEchoMethod implements \OpenXPort\Jmap\Core\Method
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        return $methodCall;
    }
}
