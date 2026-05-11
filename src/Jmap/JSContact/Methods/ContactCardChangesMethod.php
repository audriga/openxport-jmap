<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\ChangesMethod;

class ContactCardChangesMethod extends ChangesMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $sinceState = $arguments['sinceState'];
        $maxChanges = $arguments['maxChanges'] ?? 500;

        $changes = $dataAccessors['ContactCard']->getChanges($sinceState, $maxChanges, $accountId);

        return $this->buildMethodResponse($changes, $methodCall);
    }
}
