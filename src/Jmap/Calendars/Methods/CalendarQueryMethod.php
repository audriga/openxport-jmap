<?php

namespace OpenXPort\Jmap\Calendar\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;

class CalendarQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $filter = isset($arguments['filter']) ? $arguments['filter'] : null;

        // Call query method in data accessor
        $ids = $dataAccessors['Calendars']->query($accountId, $filter);

        // Use base class to build response
        return $this->buildMethodResponse($ids, $methodCall);
    }
}
