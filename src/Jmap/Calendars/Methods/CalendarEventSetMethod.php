<?php

namespace OpenXPort\Jmap\Calendar\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;
use OpenXPort\Jmap\Calendar\CalendarEvent;

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
            $jsCalendarEvent = CalendarEvent::fromJson($arguments["create"]);
            $calendarEventMap = $mapper->mapFromJmap($jsCalendarEvent, $adapter);
            $created = $dataAccessors["CalendarEvents"]->create($calendarEventMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["CalendarEvents"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
