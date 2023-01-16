<?php

namespace OpenXPort\Jmap\Calendar;

class JSCalendarDataType
{
    /**
     * Used by fromJson() to parse an array of JSON RecurrenceRule objects, as they are stored in a
     * recurrenceRule[] array in the JSCalendar format.
     */
    protected static function fromJsonArray(array $json)
    {
        $jsonEntries = [];

        foreach ($json as $entry) {
            $childClass = get_called_class();

            array_push($jsonEntries, $childClass::fromJson($entry));
        }

        return $jsonEntries;
    }
}