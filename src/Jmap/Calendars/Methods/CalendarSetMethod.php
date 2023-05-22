<?php

namespace OpenXPort\Jmap\Calendar\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;
use OpenXPort\Jmap\Calendar\Calendar;

class CalendarSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Calendars"];
        $mapper = $dataMappers["Calendars"];
        $created = [];
        $destroyed = [];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $calendarToCreate = $arguments["create"];
            $creationId = array_keys((array)$calendarToCreate)[0];

            // Since we now support deserialization, we can use that here.
            //
            // This is a bit sketchy so I will rework this at some point.
            //
            // TODO: Since we now deserialize and serialize all over the place,
            // it might be worth to consider doing this earlier.
            $calendar = Calendar::fromJson($calendarToCreate->{$creationId});
            $calendars = [$creationId => $calendar];

            $calendarMap = $mapper->mapFromJmap($calendars, $adapter);
            $created = $dataAccessors["Calendars"]->create($calendarMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Calendars"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
