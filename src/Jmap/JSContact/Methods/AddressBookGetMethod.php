<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class AddressBookGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["AddressBooks"];
        $mapper = $dataMappers["AddressBooks"];
        $state = $dataAccessors["AddressBooks"]->getCurrentState($arguments["accountId"]);

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $addressBooks = $dataAccessors["AddressBooks"]->get($arguments["ids"]);
        } else {
            $addressBooks = $dataAccessors["AddressBooks"]->getAll();
        }

        $list = $mapper->mapToJmap($addressBooks, $adapter);

        return $this->buildMethodResponse($list, $state, $methodCall);
    }
}
