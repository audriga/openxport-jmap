<?php

namespace OpenXPort\Jmap\Note\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class NotebookSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Notebooks"];
        $mapper = $dataMappers["Notebooks"];
        $accountId = isset($arguments["accountId"]) ? $arguments["accountId"] : null;

        $created = null;
        $destroyed = null;

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $notebookMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Notebooks"]->create($notebookMap, $accountId);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Notebooks"]->destroy($arguments["destroy"], $accountId);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
