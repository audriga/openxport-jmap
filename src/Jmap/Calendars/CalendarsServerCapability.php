<?php

namespace OpenXPort\Jmap\Calendar;

class CalendarsServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        // TODO Make this configurable later on by reading values from a config class
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:calendars";
    }

    public function getMethods()
    {
        return array(
            "CalendarEvent/get" => Methods\CalendarEventGetMethod::class,
            "CalendarEvent/set" => Methods\CalendarEventSetMethod::class,
            "Calendar/get" => Methods\CalendarGetMethod::class
        );
    }
}
