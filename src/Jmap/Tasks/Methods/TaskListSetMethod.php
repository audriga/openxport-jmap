<?php

namespace OpenXPort\Jmap\Tasks\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class TaskListSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["TaskLists"];
        $mapper = $dataMappers["TaskLists"];
        $accountId = isset($arguments["accountId"]) ? $arguments["accountId"] : null;

        $created = null;
        $destroyed = null;

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $taskListMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["TaskLists"]->create($taskListMap, $accountId);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["TaskLists"]->destroy($arguments["destroy"], $accountId);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
