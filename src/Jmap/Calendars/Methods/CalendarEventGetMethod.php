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
        $state = $dataAccessors["CalendarEvents"]->getCurrentState($arguments["accountId"] ?? null);

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $events = $dataAccessors["CalendarEvents"]->get($arguments["ids"], $arguments["accountId"] ?? null);
        } else {
            $events = $dataAccessors["CalendarEvents"]->getAll($arguments["accountId"] ?? null);
        }

        $logger->debug("Collected " . sizeof($events) . " calendar events");
        $list = $mapper->mapToJmap($events, $adapter);

        $logger->debug("Now returning " . sizeof($list) . " calendar events");

        return $this->buildMethodResponse($list, $state, $methodCall);
    }
}
