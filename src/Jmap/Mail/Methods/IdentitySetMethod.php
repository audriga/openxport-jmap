<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class IdentitySetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $adapter = $dataAdapters["Identities"];
        $mapper = $dataMappers["Identities"];
        $created = [];
        $destroyed = [];
        $updated = [];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $identityMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["Identities"]->create($identityMap);
        }

        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Identities"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated);
    }
}
