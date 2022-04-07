<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class IdentitySetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["Identities"];
        $mapper = $dataMappers["Identities"];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $identityMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Identities"]->create($identityMap);
        } else {
            $msg = ErrorHandler::raiseInvalidArgument(
                $methodCallId,
                "Identity/Set currently requires create parameter."
            );
            die($msg);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
