<?php

namespace OpenXPort\Jmap\Calendar\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class CalendarEventGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $logger = \OpenXPort\Util\Logger::getInstance();
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["CalendarEvents"];
        $mapper = $dataMappers["CalendarEvents"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $events = $dataAccessors["CalendarEvents"]->get($arguments["ids"]);
        } else {
            $events = $dataAccessors["CalendarEvents"]->getAll();
        }

        $logger->debug("Collected " . sizeof($events) . " calendar events");
        $list = $mapper->mapToJmap($events, $adapter);

        $logger->debug("Now returning " . sizeof($list) . " calendar events");

        return $this->buildMethodResponse($list, $methodCall);
    }
}
