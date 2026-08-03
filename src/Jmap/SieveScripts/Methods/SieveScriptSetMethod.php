<?php

namespace OpenXPort\Jmap\SieveScript\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class SieveScriptSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["SieveScripts"];
        $mapper = $dataMappers["SieveScripts"];
        $accountId = isset($arguments["accountId"]) ? $arguments["accountId"] : null;

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $sieveScriptMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["SieveScripts"]->create($sieveScriptMap, $accountId);
        }
        if (isset($arguments["update"]) && !is_null($arguments["update"])) {
            $updated = $dataAccessors["SieveScripts"]->update($arguments["update"], $accountId);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["SieveScripts"]->destroy($arguments["destroy"], $accountId);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated ?? []);
    }
}
