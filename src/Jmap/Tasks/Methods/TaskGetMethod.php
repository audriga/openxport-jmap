<?php

namespace OpenXPort\Jmap\Tasks\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class TaskGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Tasks"];
        $mapper = $dataMappers["Tasks"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $tasks = $dataAccessors["Tasks"]->get($arguments["ids"]);
        } else {
            $tasks = $dataAccessors["Tasks"]->getAll();
        }

        $list = $mapper->mapToJmap($tasks, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
