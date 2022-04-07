<?php

namespace OpenXPort\Jmap\Files\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;

class StorageNodeQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();

        if (isset($arguments["filter"]) && isset($arguments["filter"]->conditions)) {
            $msg = ErrorHandler::raiseInvalidArgument(
                $methodCallId,
                "FilterOperator not implemented. Expected FilterCondition"
            );

            die($msg);
        }
        if (isset($arguments["filter"])) {
            // TODO better create a fromJson method instead of doing it here
            $filterConditionJson = $arguments["filter"];
            $filterCondition = new \OpenXPort\Jmap\Files\FilterCondition();

            if (!is_null($filterConditionJson)) {
                if (isset($filterConditionJson->parentIds)) {
                    $attribute = $filterConditionJson->parentIds;
                    if (!is_null($attribute)) {
                        $filterCondition->setParentIds($attribute);
                    }
                }
                if (isset($filterConditionJson->ancestorIds)) {
                    $attribute = $filterConditionJson->ancestorIds;
                    if (!is_null($attribute)) {
                        $filterCondition->setAncestorIds($attribute);
                    }
                }
                if (isset($filterConditionJson->hasBlobId)) {
                    $attribute = $filterConditionJson->hasBlobId;
                    if (!is_null($attribute)) {
                        $filterCondition->setHasBlobId($attribute);
                    }
                }
            }
        }
        try {
            $list = $dataAccessors["StorageNodes"]->query($arguments["accountId"], $filterCondition);
        } catch (\Exception $e) {
            die(ErrorHandler::raiseInvalidArgument($methodCallId, $e->getMessage()));
        }

        return $this->buildMethodResponse($list, $methodCall);
    }
}
