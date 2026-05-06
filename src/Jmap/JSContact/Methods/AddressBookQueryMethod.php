<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;

class AddressBookQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $filter = isset($arguments['filter']) ? $arguments['filter'] : null;

        // Call query method in data accessor
        $ids = $dataAccessors['AddressBooks']->query($accountId, $filter);

        $ids = array_map('strval', $ids);

        return $this->buildMethodResponse($ids, $methodCall);
    }
}
