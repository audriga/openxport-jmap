<?php

namespace OpenXPort\Jmap\Files\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class StorageNodeGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["StorageNodes"];
        $mapper = $dataMappers["StorageNodes"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            try {
                $files = $dataAccessors["StorageNodes"]->get($arguments["ids"]);
            } catch (Exception $e) {
                die(ErrorHandler::raiseInvalidArgument($methodCallId, $e->getMessage()));
            }
        } else {
            $files = $dataAccessors["StorageNodes"]->getAll($accountId);
        }
        $list = $mapper->mapToJmap($files, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
