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
            $eventToCreate = $arguments["create"];
            $creationId = array_keys((array)$eventToCreate)[0];

            // Since we now support deserialization, we can use that here.
            //
            // This is a bit sketchy so I will rework this at some point.
            //
            // TODO: Since we now deserialize and serialize all over the place,
            // it might be worth to consider doing this earlier.
            $jsCalendarEvent = CalendarEvent::fromJson($eventToCreate->{$creationId});
            $jsCalendar = [$creationId => $jsCalendarEvent];

            $calendarEventMap = $mapper->mapFromJmap($jsCalendar, $adapter);
            $created = $dataAccessors["CalendarEvents"]->create($calendarEventMap);
        }

        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["CalendarEvents"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
