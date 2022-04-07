<?php

namespace OpenXPort\Jmap\Contact\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class ContactGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Contacts"];
        $mapper = $dataMappers["Contacts"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $contacts = $dataAccessors["Contacts"]->get($arguments["ids"]);
        } else {
            $contacts = $dataAccessors["Contacts"]->getAll();
        }

        $list = $mapper->mapToJmap($contacts, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
