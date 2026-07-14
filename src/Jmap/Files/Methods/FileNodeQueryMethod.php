<?php

namespace OpenXPort\Jmap\Files\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;
use OpenXPort\Jmap\Core\ErrorHandler;

class FileNodeQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();

        if (isset($arguments["filter"]) && isset($arguments["filter"]->conditions)) {
            $msg = ErrorHandler::raiseInvalidArgument(
                $methodCall->getId(),
                "FilterOperator not implemented. Expected FilterCondition"
            );

            die($msg);
        }

        $filterCondition = null;

        if (isset($arguments["filter"])) {
            // Uses FilterCondition::fromJson() to deserialize all filter fields
            $filterCondition = \OpenXPort\Jmap\Files\FilterCondition::fromJson($arguments["filter"]);
        }

        try {
            $list = $dataAccessors["FileNodes"]->query($arguments["accountId"], $filterCondition);
        } catch (\Exception $e) {
            die(ErrorHandler::raiseInvalidArgument($methodCall->getId(), $e->getMessage()));
        }

        return $this->buildMethodResponse($list, $methodCall);
    }
}
