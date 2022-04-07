<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class CardSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Cards"];
        $mapper = $dataMappers["Cards"];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $contactMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Cards"]->create($contactMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Cards"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
