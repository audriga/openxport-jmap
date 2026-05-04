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

        // Handle update
        if (isset($arguments["update"]) && !is_null($arguments["update"])) {
            $eventsToUpdate = $arguments["update"];

            foreach ($eventsToUpdate as $id => $partialEventData) {
                try {
                    $existingEvents = $dataAccessors["CalendarEvents"]->get([$id]);

                    if (empty($existingEvents) || !isset($existingEvents[$id])) {
                        continue;
                    }

                    $existingEvent = $existingEvents[$id];
                    $existingJsCalendar = $mapper->mapToJmap([$id => $existingEvent], $adapter);

                    if (empty($existingJsCalendar)) {
                        continue;
                    }

                    $existingJsEvent = reset($existingJsCalendar);
                    $existingArray = json_decode(json_encode($existingJsEvent), true);
                    $updateArray = is_array($partialEventData) ? $partialEventData :
                     json_decode(json_encode($partialEventData), true);

                    if (!isset($updateArray['calendarIds']) && isset($existingArray['calendarIds'])) {
                        $updateArray['calendarIds'] = $existingArray['calendarIds'];
                    }

                    $mergedArray = array_merge($existingArray, $updateArray);

                    // Convert array to object before passing to fromJson
                    $mergedObject = json_decode(json_encode($mergedArray));
                    $mergedJsEvent = CalendarEvent::fromJson($mergedObject);

                    if (
                        is_null($mergedJsEvent->getCalendarIds()) &&
                        isset($existingEvent['oxpProperties']['calendarId'])
                    ) {
                        $mergedJsEvent->setCalendarIds($existingEvent['oxpProperties']['calendarId']);
                    }

                    $tempId = 'temp_' . md5($id);
                    $calendarEventMap = $mapper->mapFromJmap([$tempId => $mergedJsEvent], $adapter);

                    $remappedEventMap = [];
                    if (!empty($calendarEventMap)) {
                        $firstElement = reset($calendarEventMap);
                        $eventData = reset($firstElement);
                        $remappedEventMap[$id] = $eventData;
                    }

                    $updatedEvents = $dataAccessors["CalendarEvents"]->update($remappedEventMap);

                    if (isset($updatedEvents[$id]) && $updatedEvents[$id] === true) {
                        $updated[$id] = (object)[];
                    }
                } catch (\Exception $e) {
                    error_log("Failed to update event $id: " . $e->getMessage());
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

                return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated);
    }
}
