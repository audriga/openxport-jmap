<?php

namespace OpenXPort\Jmap\Tasks\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class TaskSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Tasks"];
        $mapper = $dataMappers["Tasks"];
        $accountId = isset($arguments["accountId"]) ? $arguments["accountId"] : null;

        $created = null;
        $destroyed = null;

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $taskMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Tasks"]->create($taskMap, $accountId);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Tasks"]->destroy($arguments["destroy"], $accountId);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
