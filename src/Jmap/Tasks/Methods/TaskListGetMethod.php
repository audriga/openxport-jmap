<?php

namespace OpenXPort\Jmap\Tasks\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class TaskListGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["TaskLists"];
        $mapper = $dataMappers["TaskLists"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $calendars = $dataAccessors["TaskLists"]->get($arguments["ids"]);
        } else {
            $calendars = $dataAccessors["TaskLists"]->getAll();
        }

        $list = $mapper->mapToJmap($calendars, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
