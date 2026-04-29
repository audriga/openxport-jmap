<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class ContactCardSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments  = $methodCall->getArguments();
        $methodName = $methodCall->getName();

        // IETF ContactCard backend
        $adapter = $dataAdapters['ContactCard'];
        $mapper  = $dataMappers['ContactCard'];

        $created   = [];
        $destroyed = [];

        if (isset($arguments['create']) && $arguments['create'] !== null) {
            // Map JSContact ContactCard objects from the JMAP request into backend records
            $contactCards = [];
            foreach ($arguments['create'] as $creationId => $data) {
                $contactCards[$creationId] = \OpenXPort\Jmap\JSContact\ContactCard::fromJson($data);
            }
            $contactMap = $mapper->mapFromJmap($contactCards, $adapter);
            $created    = $dataAccessors['ContactCard']->create($contactMap);
        }

        if (isset($arguments['destroy']) && $arguments['destroy'] !== null) {
            $destroyed = $dataAccessors['ContactCard']->destroy($arguments['destroy']);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall);
    }
}
