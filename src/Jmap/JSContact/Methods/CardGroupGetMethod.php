<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class CardGroupGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["CardGroups"];
        $mapper = $dataMappers["CardGroups"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $contactGroups = $dataAccessors["CardGroups"]->get($arguments["ids"]);
        } else {
            $contactGroups = $dataAccessors["CardGroups"]->getAll();
        }

        $list = $mapper->mapToJmap($contactGroups, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
