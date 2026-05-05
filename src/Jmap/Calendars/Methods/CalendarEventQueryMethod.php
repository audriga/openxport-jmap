<?php

namespace OpenXPort\Jmap\Calendar\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;

class CalendarEventQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $filter = isset($arguments['filter']) ? $arguments['filter'] : null;

        // Call query method in data accessor
        $ids = $dataAccessors['CalendarEvents']->query($accountId, $filter);

        // Use base class to build response
        return $this->buildMethodResponse($ids, $methodCall);
    }
}
