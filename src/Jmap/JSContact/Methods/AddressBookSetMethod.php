<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class AddressBookSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["AddressBooks"];
        $mapper = $dataMappers["AddressBooks"];
        $created = [];
        $destroyed = [];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $bookMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["AddressBooks"]->create($bookMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["AddressBooks"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
