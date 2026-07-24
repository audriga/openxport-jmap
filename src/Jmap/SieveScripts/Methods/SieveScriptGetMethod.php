<?php

namespace OpenXPort\Jmap\SieveScript\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class SieveScriptGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["SieveScripts"];
        $mapper = $dataMappers["SieveScripts"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $sieveScripts = $dataAccessors["SieveScripts"]->get($arguments["ids"], $arguments["accountId"] ?? null);
        } else {
            $sieveScripts = $dataAccessors["SieveScripts"]->getAll($arguments["accountId"] ?? null);
        }

        $list = $mapper->mapToJmap($sieveScripts, $adapter);

        return $this->buildMethodResponse($list, "", $methodCall);
    }
}
