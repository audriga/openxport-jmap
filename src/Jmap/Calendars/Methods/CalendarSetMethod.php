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
        $updated = [];

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

        // Handle update operations
        if (isset($arguments["update"]) && !is_null($arguments["update"])) {
            $calendarsToUpdate = $arguments["update"];

            foreach ($calendarsToUpdate as $id => $partialCalendarData) {
                try {
                    $existingCalendars = $dataAccessors["Calendars"]->get([$id]);

                    if (empty($existingCalendars) || !isset($existingCalendars[$id])) {
                        continue;
                    }

                    $existingCalendar = $existingCalendars[$id];
                    $existingJsCalendar = $mapper->mapToJmap([$id => $existingCalendar], $adapter);

                    if (empty($existingJsCalendar)) {
                        continue;
                    }

                    $existingJsCalendar = reset($existingJsCalendar);
                    $existingArray = json_decode(json_encode($existingJsCalendar), true);
                    $updateArray = is_array($partialCalendarData) ? $partialCalendarData
                        : json_decode(json_encode($partialCalendarData), true);

                    $mergedArray = array_merge($existingArray, $updateArray);

                    $updatedCalendars = $dataAccessors["Calendars"]->update([$id => $mergedArray]);

                    if (isset($updatedCalendars[$id]) && $updatedCalendars[$id] === true) {
                        $updated[$id] = (object)[];
                    }
                } catch (\Exception $e) {
                    error_log("Failed to update calendar $id: " . $e->getMessage());
                }
            }
        }

        // Handle destroy operations
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            try {
                $destroyed = $dataAccessors["Calendars"]->destroy($arguments["destroy"]);
            } catch (\Exception $e) {
                error_log("Failed to destroy calendars: " . $e->getMessage());
            }
        }
        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated);
    }
}
