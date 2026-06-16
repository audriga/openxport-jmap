<?php

namespace OpenXPort\Jmap\Files\Methods;

use OpenXPort\Jmap\Core\Methods\QueryChangesMethod;

class FileNodeQueryChangesMethod extends QueryChangesMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $sinceQueryState = $arguments['sinceQueryState'];
        $maxChanges = $arguments['maxChanges'] ?? 500;
        $filter = isset($arguments['filter']) ? $arguments['filter'] : null;
        $sort = isset($arguments['sort']) ? $arguments['sort'] : null;

        $result = $dataAccessors['FileNodes']->getQueryChanges(
            $sinceQueryState,
            $maxChanges,
            $filter,
            $sort,
            $accountId
        );

        return $this->buildMethodResponse($result, $methodCall);
    }
}
