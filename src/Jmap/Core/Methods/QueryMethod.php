<?php

namespace OpenXPort\Jmap\Core\Methods;

use OpenXPort\Jmap\Core\Invocation;

abstract class QueryMethod implements \OpenXPort\Jmap\Core\Method
{
    protected function buildMethodResponse($list, $methodCall)
    {
        $args = array(
            "queryState" => "someState",
            "ids" => $list,
            "notFound" => [],
            "accountId" => $methodCall->getArguments()["accountId"],
            "canCalculateChanges" => false,
            "position" => 0
        );

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }

    abstract public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
