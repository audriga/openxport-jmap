<?php

namespace OpenXPort\Jmap\Core\Methods;

use OpenXPort\Jmap\Core\Invocation;

abstract class ChangesMethod implements \OpenXPort\Jmap\Core\Method
{
    protected function buildMethodResponse($changes, $methodCall)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $sinceState = isset($arguments['sinceState']) ? $arguments['sinceState'] : null;

        $args = array(
            "accountId" => $accountId,
            "oldState" => $sinceState,
            "newState" => $changes['newState'],
            "hasMoreChanges" => false,
            "created" => $changes['created'],
            "updated" => $changes['updated'],
            "destroyed" => $changes['destroyed']
        );

        return new Invocation(
            $methodCall->getName(),
            $args,
            $methodCall->getMethodCallId()
        );
    }

    abstract public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
