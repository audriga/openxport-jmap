<?php

namespace OpenXPort\Jmap\Calendar;

class CalendarsAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        // TODO Make this configurable later on by reading values from a config class
        $this->options = array(
            'shareesActAs' => "self",
            'maxCalendarsPerEvent' => null,
            'minDateTime' => "1970-01-01T00:00:00",
            'maxDateTime' => "2100-31-12T23:59:59",
            'maxExpandedQueryDuration' => "P0D",
            'maxParticipantsPerEvent' => null,
            'mayCreateCalendar' => true
        );
        $this->name = "urn:ietf:params:jmap:calendars";
    }

    public function getProperties()
    {
        return $this->options;
    }

    public function getMethods()
    {
        return array(
            "CalendarEvent/get" => Methods\CalendarEventGetMethod::class,
            "Calendar/get" => Methods\CalendarGetMethod::class
        );
    }

    public function getName()
    {
        return $this->name;
    }
}
