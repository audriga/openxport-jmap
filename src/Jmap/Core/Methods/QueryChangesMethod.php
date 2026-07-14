<?php

namespace OpenXPort\Jmap\Core\Methods;

use OpenXPort\Jmap\Core\Invocation;

abstract class QueryChangesMethod implements \OpenXPort\Jmap\Core\Method
{
    protected function buildMethodResponse($result, $methodCall)
    {
        $accountId = $methodCall->getArguments()["accountId"];
        $sinceQueryState = $methodCall->getArguments()["sinceQueryState"];

        $args = [
            "accountId" => $accountId,
            "oldQueryState" => $sinceQueryState,
            "newQueryState" => $result['newQueryState'],
            "removed" => $result['removed'],
            "added" => $result['added'],
        ];

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }

    abstract public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
