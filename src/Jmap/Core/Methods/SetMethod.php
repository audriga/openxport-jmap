<?php

namespace OpenXPort\Jmap\Core\Methods;

use OpenXPort\Jmap\Core\Invocation;

abstract class SetMethod implements \OpenXPort\Jmap\Core\Method
{
    protected function buildMethodResponse($createMap, $destroyMap, $methodCall, $updateMap = [])
    {
        $accountId = $methodCall->getArguments()["accountId"];

        // TODO We would need to support the Session->getState() somehow
        $newState = "";
        $created = [];
        $updated = [];
        $destroyed = [];
        $notCreated = [];
        $notUpdated = [];
        $notDestroyed = [];

        if ($createMap) {
            foreach (array_keys($createMap) as $createId) {
                $id = $createMap[$createId];

                if ($id === false) {
                    $setError = array(
                        "type" => "invalidProperties",
                        "description" => "There was an error when creating the object");
                    $notCreated[$createId] = $setError;
                } else {
                    $additional_props = array("id" => $id, "uid" => $id);
                    $created[$createId] = $additional_props;
                }
            }
        }

        if ($updateMap) {
            foreach (array_keys($updateMap) as $updateId) {
                $success = $updateMap[$updateId];

                if ($success === false || $success === 0) {
                    $setError = array(
                        "type" => "invalidProperties",
                        "description" => "There was an error when updating the object");
                    $notUpdated[$updateId] = $setError;
                } else {
                    $updated[$updateId] = (object)[];
                }
            }
        }

        if ($destroyMap) {
            foreach (array_keys($destroyMap) as $destroyId) {
                $success = $destroyMap[$destroyId];

                if ($success != 1) {
                    $setError = array(
                        "type" => "invalidProperties",
                        "description" => "There was an error when destroying the object");
                    $notDestroyed[$destroyId] = $setError;
                } else {
                    array_push($destroyed, (string) $destroyId);
                }
            }
        }

        $args = array(
            "accountId" => $accountId,
            "newState" => $newState,
            "created" => $created,
            "updated" => $updated,
            "destroyed" => $destroyed,
            "notCreated" => $notCreated,
            "notUpdated" => $notUpdated,
            "notDestroyed" => $notDestroyed
        );

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }


    abstract public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
