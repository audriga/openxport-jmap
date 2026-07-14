<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class EmailGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $adapter = $dataAdapters["Emails"];
        $mapper = $dataMappers["Emails"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $emails = $dataAccessors["Emails"]->get($arguments["ids"]);
        } else {
            $emails = $dataAccessors["Emails"]->getAll();
        }

        $list = $mapper->mapToJmap($emails, $adapter);

        return $this->buildMethodResponse($list, "", $methodCall);
    }
}
