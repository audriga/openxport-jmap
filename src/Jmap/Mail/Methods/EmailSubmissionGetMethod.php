<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class EmailSubmissionGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $adapter = $dataAdapters["EmailSubmissions"];
        $mapper = $dataMappers["EmailSubmissions"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $submissions = $dataAccessors["EmailSubmissions"]->get($arguments["ids"], $arguments["accountId"] ?? null);
        } else {
            $submissions = $dataAccessors["EmailSubmissions"]->getAll($arguments["accountId"] ?? null);
        }

        $list = $mapper->mapToJmap($submissions, $adapter);

        return $this->buildMethodResponse($list, "", $methodCall);
    }
}
