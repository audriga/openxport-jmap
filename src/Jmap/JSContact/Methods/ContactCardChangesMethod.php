<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\ChangesMethod;

class ContactCardChangesMethod extends ChangesMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $sinceState = isset($arguments['sinceState']) ? $arguments['sinceState'] : null;

        // Get changes from data accessor
        $changes = $dataAccessors['ContactCard']->changes($accountId, $sinceState);

        return $this->buildMethodResponse($changes, $methodCall);
    }
}
