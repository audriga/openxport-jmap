<?php

namespace OpenXPort\Jmap\Contact\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class ContactCardSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments  = $methodCall->getArguments();
        $methodName = $methodCall->getName();

        // IETF ContactCard backend wiring
        $adapter = $dataAdapters['ContactCard'];
        $mapper  = $dataMappers['ContactCard'];

        $created   = [];
        $destroyed = [];

        if (isset($arguments['create']) && $arguments['create'] !== null) {
            // Map JSContact ContactCard objects from the JMAP request into backend records
            $contactMap = $mapper->mapFromJmap($arguments['create'], $adapter);
            $created    = $dataAccessors['ContactCard']->create($contactMap);
        }

        if (isset($arguments['destroy']) && $arguments['destroy'] !== null) {
            $destroyed = $dataAccessors['ContactCard']->destroy($arguments['destroy']);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
