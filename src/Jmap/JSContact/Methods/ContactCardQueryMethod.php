<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;

class ContactCardQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $filter = isset($arguments['filter']) ? $arguments['filter'] : null;

        // Call query method in data accessor
        $result = $dataAccessors['ContactCard']->query($accountId, $filter);

        // Use base class to build response
        return $this->buildMethodResponse($result['ids'], $methodCall);
    }
}
