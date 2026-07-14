<?php

namespace OpenXPort\Jmap\Files\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;
use OpenXPort\Jmap\Core\ErrorHandler;

class FileNodeGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["FileNodes"];
        $mapper = $dataMappers["FileNodes"];
        $accountId = isset($arguments["accountId"]) ? $arguments["accountId"] : null;

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            try {
                $files = $dataAccessors["FileNodes"]->get($arguments["ids"]);
            } catch (\Exception $e) {
                die(ErrorHandler::raiseInvalidArgument($methodCall->getId(), $e->getMessage()));
            }
        } else {
            $files = $dataAccessors["FileNodes"]->getAll($accountId);
        }
        $list = array_values($mapper->mapToJmap($files, $adapter));
        $state = $dataAccessors["FileNodes"]->getCurrentState($accountId);

        return $this->buildMethodResponse($list, $state, $methodCall);
    }
}
