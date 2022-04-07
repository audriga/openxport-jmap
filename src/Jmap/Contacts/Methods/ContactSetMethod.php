<?php

namespace OpenXPort\Jmap\Contact\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class ContactSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Contacts"];
        $mapper = $dataMappers["Contacts"];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $contactMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Contacts"]->create($contactMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Contacts"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
