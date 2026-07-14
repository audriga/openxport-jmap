<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;

class EmailQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();

        $ids = $dataAccessors["Emails"]->query($arguments["accountId"]);

        return $this->buildMethodResponse($ids, $methodCall);
    }
}
