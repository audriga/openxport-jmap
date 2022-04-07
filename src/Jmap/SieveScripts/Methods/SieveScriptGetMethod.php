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
            $sieveScripts = $dataAccessors["SieveScripts"]->get($arguments["ids"]);
        } else {
            $sieveScripts = $dataAccessors["SieveScripts"]->getAll();
        }

        $list = $mapper->mapToJmap($sieveScripts, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
