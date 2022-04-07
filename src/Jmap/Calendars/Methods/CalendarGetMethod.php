<?php

namespace OpenXPort\Jmap\Calendar\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class CalendarGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $logger = \OpenXPort\Util\Logger::getInstance();
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Calendars"];
        $mapper = $dataMappers["Calendars"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $calendars = $dataAccessors["Calendars"]->get($arguments["ids"]);
        } else {
            $calendars = $dataAccessors["Calendars"]->getAll();
        }

        $logger->debug("Collected " . sizeof($calendars) . " calendars");
        $list = $mapper->mapToJmap($calendars, $adapter);

        $logger->debug("Now returning " . sizeof($list) . " calendars");

        return $this->buildMethodResponse($list, $methodCall);
    }
}
