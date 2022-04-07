<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class CardGroupSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["CardGroups"];
        $mapper = $dataMappers["CardGroups"];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $contactGroupMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["CardGroups"]->create($contactGroupMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["CardGroups"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
