<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class CardGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Cards"];
        $mapper = $dataMappers["Cards"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $contacts = $dataAccessors["Cards"]->get($arguments["ids"]);
        } else {
            $contacts = $dataAccessors["Cards"]->getAll();
        }

        $list = $mapper->mapToJmap($contacts, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
