<?php

namespace OpenXPort\Jmap\Core\Methods;

use OpenXPort\Jmap\Core\Invocation;

abstract class ChangesMethod implements \OpenXPort\Jmap\Core\Method
{
    protected function buildMethodResponse($changes, $methodCall)
    {
        $accountId = $methodCall->getArguments()["accountId"];
        $sinceState = $methodCall->getArguments()["sinceState"];

        $args = [
            "accountId" => $accountId,
            "oldState" => $sinceState,
            "newState" => $changes['newState'],
            "hasMoreChanges" => $changes['hasMoreChanges'],
            "created" => $changes['created'],
            "updated" => $changes['updated'],
            "destroyed" => $changes['destroyed']
        ];

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }

    abstract public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
