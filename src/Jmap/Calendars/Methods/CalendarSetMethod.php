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
            $calendarsToCreate = $arguments["create"];
 
            foreach ($calendarsToCreate as $creationId => $calendarData) {
                try {
                    $calendar = Calendar::fromJson($calendarData);
                    $calendars = [$creationId => $calendar];
 
                    $calendarMap = $mapper->mapFromJmap($calendars, $adapter);
                    
                    $createdCalendars = $dataAccessors["Calendars"]->create($calendarMap);
                    $created = array_merge($created, $createdCalendars);
                } catch (\Exception $e) {
                    error_log("Failed to create calendar $creationId: " . $e->getMessage());
                }
            }
        }
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            try {
                $destroyed = $dataAccessors["Calendars"]->destroy($arguments["destroy"]);
            } catch (\Exception $e) {
                // Handle destruction errors
                error_log("Failed to destroy calendars: " . $e->getMessage());
            }
        }
        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
