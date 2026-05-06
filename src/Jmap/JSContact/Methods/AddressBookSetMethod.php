<?php

namespace OpenXPort\Jmap\JSContact\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;
use OpenXPort\Jmap\JSContact\AddressBook;

class AddressBookSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["AddressBooks"];
        $mapper = $dataMappers["AddressBooks"];
        $created = [];
        $updated = [];
        $destroyed = [];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $bookMap = $mapper->mapFromJmap($arguments["create"], $adapter);
            $created = $dataAccessors["AddressBooks"]->create($bookMap);
        }

        // Handle update operations
        if (isset($arguments["update"]) && !is_null($arguments["update"])) {
            $addressbooksToUpdate = $arguments["update"];

            foreach ($addressbooksToUpdate as $id => $partialAddressbookData) {
                try {
                    $existingAddressbooks = $dataAccessors["AddressBooks"]->get([$id]);

                    if (empty($existingAddressbooks) || !isset($existingAddressbooks[$id])) {
                        continue;
                    }

                    $existingAddressbook = $existingAddressbooks[$id];
                    $existingJsAddressbook = $mapper->mapToJmap([$id => $existingAddressbook], $adapter);

                    if (empty($existingJsAddressbook)) {
                        continue;
                    }

                    $existingJsAddressbook = reset($existingJsAddressbook);
                    $existingArray = json_decode(json_encode($existingJsAddressbook), true);
                    $updateArray = is_array($partialAddressbookData) ? $partialAddressbookData
                        : json_decode(json_encode($partialAddressbookData), true);

                    $mergedArray = array_merge($existingArray, $updateArray);

                    $updatedAddressbooks = $dataAccessors["AddressBooks"]->update([$id => $mergedArray]);

                    if (isset($updatedAddressbooks[$id]) && $updatedAddressbooks[$id] === true) {
                        $updated[$id] = (object)[];
                    }
                } catch (\Exception $e) {
                    error_log("Failed to update address book $id: " . $e->getMessage());
                }
            }
        }

        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["AddressBooks"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated);
    }
}
