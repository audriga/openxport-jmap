<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class VacationResponseGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["VacationResponses"];
        $mapper = $dataMappers["VacationResponses"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $vacationResponses = $dataAccessors["VacationResponses"]->get($arguments["ids"]);
        } else {
            $vacationResponses = $dataAccessors["VacationResponses"]->getAll();
        }

        $list = $mapper->mapToJmap($vacationResponses, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
