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
        $updated   = [];
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

        // Handle update operations
        if (isset($arguments['update']) && $arguments['update'] !== null) {
            $contactsToUpdate = $arguments['update'];

            foreach ($contactsToUpdate as $id => $partialContactData) {
                try {
                    // Get existing contact
                    $existingContacts = $dataAccessors['ContactCard']->get([$id]);

                    if (empty($existingContacts) || !isset($existingContacts[$id])) {
                        continue;
                    }

                    $existingContact = $existingContacts[$id];
                    $existingJsContact = $mapper->mapToJmap([$id => $existingContact], $adapter);

                    if (empty($existingJsContact)) {
                        continue;
                    }

                    $existingJsContact = reset($existingJsContact);
                    $existingArray = json_decode(json_encode($existingJsContact), true);
                    $updateArray = is_array($partialContactData) ? $partialContactData
                        : json_decode(json_encode($partialContactData), true);

                    $mergedArray = array_merge($existingArray, $updateArray);

                    // Map merged data back to vCard format
                    $mergedContact = \OpenXPort\Jmap\JSContact\ContactCard::fromJson($mergedArray);
                    $mappedContact = $mapper->mapFromJmap([$id => $mergedContact], $adapter);

                    $updatedContacts = $dataAccessors['ContactCard']->update([$id => reset($mappedContact)]);

                    if (isset($updatedContacts[$id]) && $updatedContacts[$id] === true) {
                        $updated[$id] = (object)[];
                    }
                } catch (\Exception $e) {
                    error_log("Failed to update contact $id: " . $e->getMessage());
                }
            }
        }

        if (isset($arguments['destroy']) && $arguments['destroy'] !== null) {
            $destroyed = $dataAccessors['ContactCard']->destroy($arguments['destroy']);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated);
    }
}
