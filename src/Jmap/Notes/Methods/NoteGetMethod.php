<?php

namespace OpenXPort\Jmap\Note\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class NoteGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Notes"];
        $mapper = $dataMappers["Notes"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $notes = $dataAccessors["Notes"]->get($arguments["ids"]);
        } else {
            $notes = $dataAccessors["Notes"]->getAll();
        }

        $list = $mapper->mapToJmap($notes, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
