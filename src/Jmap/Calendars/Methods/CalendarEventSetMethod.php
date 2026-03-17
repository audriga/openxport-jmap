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
        $updated = [];
        $destroyed = [];

        // Handle create operations
        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $eventsToCreate = $arguments["create"];

            foreach ($eventsToCreate as $creationId => $eventData) {
                try {
                    // Deserialize the JSCalendar Event from JSON
                    $jsCalendarEvent = CalendarEvent::fromJson($eventData);
                    $jsCalendar = [$creationId => $jsCalendarEvent];

                    $calendarEventMap = $mapper->mapFromJmap($jsCalendar, $adapter);
                    
                    $createdEvents = $dataAccessors["CalendarEvents"]->create($calendarEventMap);
                    $created = array_merge($created, $createdEvents);
                } catch (\Exception $e) {
                    error_log("Failed to create event $creationId: " . $e->getMessage());
                }
            }
        }

        // Handle destroy operations
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            try {
                $destroyed = $dataAccessors["CalendarEvents"]->destroy($arguments["destroy"]);
            } catch (\Exception $e) {
                error_log("Failed to destroy events: " . $e->getMessage());
            }
        }

        return $this->buildMethodResponse($created, $updated, $destroyed, $methodCall);
    }
}