<?php

namespace OpenXPort\Jmap\Preferences\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class PreferencesGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Preferences"];
        $mapper = $dataMappers["Preferences"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $preferences = $dataAccessors["Preferences"]->get($arguments["ids"]);
        } else {
            $preferences = $dataAccessors["Preferences"]->getAll();
        }

        $list = $mapper->mapToJmap($preferences, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
