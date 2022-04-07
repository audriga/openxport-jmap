<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class IdentityGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Identities"];
        $mapper = $dataMappers["Identities"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $identities = $dataAccessors["Identities"]->get($arguments["ids"]);
        } else {
            $identities = $dataAccessors["Identities"]->getAll();
        }

        $list = $mapper->mapToJmap($identities, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
