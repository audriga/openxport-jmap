<?php

namespace OpenXPort\Jmap\Note\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class NotebookGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Notebooks"];
        $mapper = $dataMappers["Notebooks"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $notebooks = $dataAccessors["Notebooks"]->get($arguments["ids"]);
        } else {
            $notebooks = $dataAccessors["Notebooks"]->getAll();
        }

        $list = $mapper->mapToJmap($notebooks, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
