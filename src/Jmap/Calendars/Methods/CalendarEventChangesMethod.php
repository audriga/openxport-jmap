<?php

namespace OpenXPort\Jmap\JSCalendar\Methods;

use OpenXPort\Jmap\Core\Methods\ChangesMethod;

class CalendarEventChangesMethod extends ChangesMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $sinceState = $arguments['sinceState'];
        $maxChanges = $arguments['maxChanges'] ?? 1000;

        $changes = $dataAccessors['CalendarEvent']->getChanges($sinceState, $maxChanges, $accountId);

        return $this->buildMethodResponse($changes, $methodCall);
    }
}
