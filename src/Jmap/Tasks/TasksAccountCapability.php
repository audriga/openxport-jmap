<?php

namespace OpenXPort\Jmap\Tasks;

class TasksAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        // TODO Make this configurable later on by reading values from a config class
        $this->capabilities = array(
            'shareesActAs' => "self",
            'maxCalendarsPerEvent' => null,
            'minDateTime' => "1970-01-01T00:00:00",
            'maxDateTime' => "2100-31-12T23:59:59",
            'maxExpandedQueryDuration' => "P0D",
            'maxAssigneesPerTask' => null,
            'mayCreateTaskList' => true
        );
        $this->name = "urn:ietf:params:jmap:tasks";
    }
}
