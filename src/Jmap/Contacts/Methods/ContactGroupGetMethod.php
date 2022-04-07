<?php

namespace OpenXPort\Jmap\Contact\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class ContactGroupGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["ContactGroups"];
        $mapper = $dataMappers["ContactGroups"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $contactGroups = $dataAccessors["ContactGroups"]->get($arguments["ids"]);
        } else {
            $contactGroups = $dataAccessors["ContactGroups"]->getAll();
        }

        $list = $mapper->mapToJmap($contactGroups, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
