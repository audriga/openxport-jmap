<?php

namespace OpenXPort\Jmap\Core\Methods;

use OpenXPort\Jmap\Core\Invocation;

abstract class QueryMethod implements \OpenXPort\Jmap\Core\Method
{
    protected function buildMethodResponse($list, $methodCall)
    {
        $arguments = $methodCall->getArguments();

        $position = $arguments["position"] ?? 0;
        if ($position < 0) {
            $position = max(0, count($list) + $position);
        }

        $limit = $arguments["limit"] ?? null;
        $page = $limit !== null ? array_slice($list, $position, $limit) : array_slice($list, $position);

        $args = array(
            "queryState" => "",
            "ids" => array_values($page),
            "notFound" => [],
            "accountId" => $arguments["accountId"],
            "canCalculateChanges" => false,
            "position" => $position
        );

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }

    abstract public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
