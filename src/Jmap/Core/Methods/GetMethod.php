<?php

namespace OpenXPort\Jmap\Core\Methods;

use OpenXPort\Jmap\Core\Invocation;

abstract class GetMethod implements \OpenXPort\Jmap\Core\Method
{
    protected function buildMethodResponse($list, $methodCall)
    {
        $accountId = $methodCall->getArguments()["accountId"];
        $args = array("state" => "someState", "list" => $list, "notFound" => [], "accountId" => $accountId);

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }

    abstract public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
