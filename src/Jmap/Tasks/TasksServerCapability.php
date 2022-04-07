<?php

namespace OpenXPort\Jmap\Tasks;

class TasksServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        // TODO Make this configurable later on by reading values from a config class
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:tasks";
    }

    public function getMethods()
    {
        return array(
            "Task/get" => Methods\TaskGetMethod::class,
            "TaskList/get" => Methods\TaskListGetMethod::class,
        );
    }
}
