<?php

namespace OpenXPort\Jmap\Calendar\Methods;

use OpenXPort\Jmap\Core\Methods\ChangesMethod;

class CalendarEventChangesMethod extends ChangesMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $sinceState = $arguments['sinceState'];
        $maxChanges = $arguments['maxChanges'] ?? 500;

        $changes = $dataAccessors['CalendarEvents']->getChanges($sinceState, $maxChanges, $accountId);

        return $this->buildMethodResponse($changes, $methodCall);
    }
}