<?php

namespace OpenXPort\Jmap\Calendars\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class CalendarEventSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["CalendarEvents"];
        $mapper = $dataMappers["CalendarEvents"];
        $created = [];
        $destroyed = [];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $calendarEventMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["CalendarEvents"]->create($calendarEventMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["CalendarEvents"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
