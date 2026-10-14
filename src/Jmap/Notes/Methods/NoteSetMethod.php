<?php

namespace OpenXPort\Jmap\Note\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class NoteSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Notes"];
        $mapper = $dataMappers["Notes"];
        $accountId = isset($arguments["accountId"]) ? $arguments["accountId"] : null;

        $created = null;
        $destroyed = null;

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $noteMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Notes"]->create($noteMap, $accountId);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Notes"]->destroy($arguments["destroy"], $accountId);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
