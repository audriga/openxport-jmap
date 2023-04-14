<?php

namespace OpenXPort\Jmap\Calendars\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

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
            $calendarMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Calendars"]->create($calendarMap);
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Calendars"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
