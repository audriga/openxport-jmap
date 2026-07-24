<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class ContactCardGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments  = $methodCall->getArguments();
        $methodName = $methodCall->getName();

        // IETF ContactCard
        $adapter = $dataAdapters['ContactCard'];
        $mapper  = $dataMappers['ContactCard'];

        if (isset($arguments['ids']) && $arguments['ids'] !== null) {
            $contacts = $dataAccessors['ContactCard']->get($arguments['ids'], $arguments['accountId'] ?? null);
        } else {
            $contacts = $dataAccessors['ContactCard']->getAll($arguments['accountId'] ?? null);
        }

        $list = $mapper->mapToJmap($contacts, $adapter);

        // Get current state
        $state = $dataAccessors['ContactCard']->getCurrentState();

        return $this->buildMethodResponse($list, $state, $methodCall);
    }
}
