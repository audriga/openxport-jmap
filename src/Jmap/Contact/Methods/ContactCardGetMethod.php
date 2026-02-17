<?php

namespace OpenXPort\Jmap\Contact\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class ContactCardGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments  = $methodCall->getArguments();
        $methodName = $methodCall->getName();

        // IETF ContactCard wiring
        $adapter = $dataAdapters['ContactCard'];
        $mapper  = $dataMappers['ContactCard'];

        if (isset($arguments['ids']) && $arguments['ids'] !== null) {
            $contacts = $dataAccessors['ContactCard']->get($arguments['ids']);
        } else {
            $contacts = $dataAccessors['ContactCard']->getAll();
        }

        $list = $mapper->mapToJmap($contacts, $adapter);

        return $this->buildMethodResponse($list, $methodCall);
    }
}
