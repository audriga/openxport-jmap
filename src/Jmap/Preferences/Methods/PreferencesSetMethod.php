<?php

namespace OpenXPort\Jmap\Preferences\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class PreferencesSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Preferences"];
        $mapper = $dataMappers["Preferences"];
        $accountId = isset($arguments["accountId"]) ? $arguments["accountId"] : null;

        $created = null;
        $updated = null;
        $destroyed = null;

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $preferencesMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Preferences"]->create($preferencesMap, $accountId);
        }
        if (isset($arguments["update"]) && !is_null($arguments["update"])) {
            $updated = $dataAccessors["Preferences"]->update($arguments["update"], $accountId);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Preferences"]->destroy($arguments["destroy"], $accountId);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated ?? []);
    }
}
