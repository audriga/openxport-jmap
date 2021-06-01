<?php

namespace Jmap\Core;

/**
 * Server class which serves as the main entry point of the JMAP Library.
 */
class Server
{

    private $dataAccessors;

    private $dataAdapters;

    private $dataMappers;

    /**
     * The constructor method of the Server class
     *
     * @param AbstractDataAccess $dataAccessors The data access classes used for working with data
     * @param AbstractAdapter $dataAdapters The adapter classes used for data transformation
     * @param AbstractMapper $dataMappers The data mapper classes used for mapping data between formats
     */
    public function __construct($dataAccessors, $dataAdapters, $dataMappers)
    {
        $this->dataAccessors = $dataAccessors;
        $this->dataAdapters = $dataAdapters;
        $this->dataMappers = $dataMappers;
    }

    public function listen()
    {

        // Take JSON POST body and decode it in order to feed it into "Server::handleJmapRequest()"
        $postBody = file_get_contents('php://input');
        $jmapRequest = json_decode($postBody);

        if (strcmp($_SERVER['REQUEST_METHOD'], "GET") === 0) {
            echo $this->returnJmapSessionResource();
        } elseif (strcmp($_SERVER['REQUEST_METHOD'], "POST") === 0) {
            echo $this->handleJmapRequest($jmapRequest);
        }
    }

    /**
     * This method deals with receiving, analyzing and parsing/processing incoming JMAP requests
     *
     * @param object $request The JMAP request which is to be processed
     */
    private function handleJmapRequest($request)
    {

        // Read the different parts of the JSON JMAP Request and place them nicely in variables
        // and make sure it is a valid request
        $using = $request->using;

        if (!is_array($using) || is_null($using) || empty($using)) {
            die($this->errorNotRequest());
        }

        $methodCalls = $request->methodCalls;

        if (!is_array($methodCalls) || is_null($methodCalls) || empty($methodCalls)) {
            die($this->errorNotRequest());
        }

        $methodName = $methodCalls[0][0];

        if (is_null($methodName)) {
            die($this->errorNotRequest());
        }

        $methodCallId = $methodCalls[0][2];

        if (is_null($methodCallId)) {
            die($this->errorNotRequest());
        }

        $accountId = $methodCalls[0][1]->accountId;

        if (in_array("urn:ietf:params:jmap:contacts", $using)) {
            if (strcmp($methodName, "Contact/get") === 0) {
                $adapter = $this->dataAdapters["Contacts"];
                $mapper = $this->dataMappers["Contacts"];

                if (isset($methodCalls[0][1]->ids) && !is_null($methodCalls[0][1]->ids)) {
                    $contacts = $this->dataAccessors["Contacts"]->get($methodCalls[0][1]->ids);
                } else {
                    $contacts = $this->dataAccessors["Contacts"]->getAll();
                }

                $list = $mapper->mapToJmap($contacts, $adapter);

                echo $this->buildJmapGetResponse($list, $accountId, $methodName, $methodCallId);
            } elseif (strcmp($methodCalls[0][0], "Contact/set") === 0) {
                $adapter = $this->dataAdapters["Contacts"];
                $mapper = $this->dataMappers["Contacts"];
                $idMap = [];

                if (isset($methodCalls[0][1]->create) && !is_null($methodCalls[0][1]->create)) {
                    $contactMap = $mapper->mapFromJmap($methodCalls[0][1]->create, $adapter);
                    $created = $this->dataAccessors["Contacts"]->create($contactMap);
                }
                if (isset($methodCalls[0][1]->destroy) && !is_null($methodCalls[0][1]->destroy)) {
                    $destroyed = $this->dataAccessors["Contacts"]->destroy($methodCalls[0][1]->destroy);
                }

                echo $this->buildJmapSetResponse($created, $destroyed, $accountId, $methodName, $methodCallId);
            } else {
                echo $this->errorUnknownMethod($methodCallId);
            }
        } elseif (in_array("urn:ietf:params:jmap:calendars", $using)) {
            if (strcmp($methodCalls[0][0], "CalendarEvent/get") === 0) {
                $adapter = $this->dataAdapters["Calendars"];
                $mapper = $this->dataMappers["Calendars"];

                if (isset($methodCalls[0][1]->ids) && !is_null($methodCalls[0][1]->ids)) {
                    $contacts = $this->dataAccessors["Calendars"]->get($methodCalls[0][1]->ids);
                } else {
                    $contacts = $this->dataAccessors["Calendars"]->getAll();
                }

                $list = $mapper->mapToJmap($events, $adapter);

                echo $this->buildJmapGetResponse($list, $accountId, $methodName, $methodCallId);
            } else {
                echo $this->errorUnknownMethod($methodCallId);
            }
        } elseif (in_array("urn:ietf:params:jmap:files", $using)) {
            $adapter = $this->dataAdapters["Files"];
            $mapper = $this->dataMappers["Files"];

            if (strcmp($methodCalls[0][0], "StorageNode/get") === 0) {
                if (isset($methodCalls[0][1]->ids) && !is_null($methodCalls[0][1]->ids)) {
                    try {
                        $files = $this->dataAccessors["Files"]->get($accountId, $methodCalls[0][1]->ids);
                    } catch (Exception $e) {
                        die($this->errorInvalidArgument($methodCallId, $e->getMessage()));
                    }
                } else {
                    $files = $this->dataAccessors["Files"]->getAll($accountId);
                }
                $list = $mapper->mapToJmap($files, $adapter);
                echo $this->buildJmapGetResponse($list, $accountId, $methodName, $methodCallId);
            } elseif (strcmp($methodCalls[0][0], "StorageNode/query") === 0) {
                if (isset($methodCalls[0][1]->filter) && isset($methodCalls[0][1]->filter->conditions)) {
                    $msg = $this->errorInvalidArgument(
                        $methodCallId,
                        "FilterOperator not implemented. Expected FilterCondition"
                    );

                    die($msg);
                }
                if (isset($methodCalls[0][1]->filter)) {
                    $filterConditionJson = $methodCalls[0][1]->filter;
                    $filterCondition = new \Jmap\Files\FilterCondition();

                    if (!is_null($filterConditionJson)) {
                        if (isset($filterConditionJson->parentIds)) {
                            $attribute = $filterConditionJson->parentIds;
                            if (!is_null($attribute)) {
                                $filterCondition->setParentIds($attribute);
                            }
                        }
                        if (isset($filterConditionJson->ancestorIds)) {
                            $attribute = $filterConditionJson->ancestorIds;
                            if (!is_null($attribute)) {
                                $filterCondition->setAncestorIds($attribute);
                            }
                        }
                        if (isset($filterConditionJson->hasBlobId)) {
                            $attribute = $filterConditionJson->hasBlobId;
                            if (!is_null($attribute)) {
                                $filterCondition->setHasBlobId($attribute);
                            }
                        }
                    }
                }
                try {
                    $list = $this->dataAccessors["Files"]->query($accountId, $filterCondition);
                } catch (Exception $e) {
                    die($this->errorInvalidArgument($methodCallId, $e->getMessage()));
                }
                echo $this->buildJmapQueryResponse($list, $accountId, $methodName, $methodCallId);
            } else {
                echo $this->errorUnknownMethod($methodCallId);
            }
        } elseif (in_array("urn:ietf:params:jmap:tasks", $using)) {
            if (strcmp($methodCalls[0][0], "Task/get") === 0) {
                $adapter = $this->dataAdapters["Tasks"];
                $mapper = $this->dataMappers["Tasks"];

                if (isset($methodCalls[0][1]->ids) && !is_null($methodCalls[0][1]->ids)) {
                    $tasks = $this->dataAccessors["Tasks"]->get($methodCalls[0][1]->ids);
                } else {
                    $tasks = $this->dataAccessors["Tasks"]->getAll();
                }

                $list = $mapper->mapToJmap($tasks, $adapter);

                echo $this->buildJmapGetResponse($list, $accountId, $methodName, $methodCallId);
            } else {
                echo $this->errorUnknownMethod($methodCallId);
            }
        } elseif (in_array("urn:ietf:params:jmap:submission", $using)) {
            if (strcmp($methodName, "Identity/get") === 0) {
                $adapter = $this->dataAdapters["Settings"];
                $mapper = $this->dataMappers["Settings"];

                if (isset($methodCalls[0][1]->ids) && !is_null($methodCalls[0][1]->ids)) {
                    $contacts = $this->dataAccessors["Settings"]->get($methodCalls[0][1]->ids);
                } else {
                    $contacts = $this->dataAccessors["Settings"]->getAll();
                }

                $list = $mapper->mapToJmap($contacts, $adapter);

                echo $this->buildJmapGetResponse($list, $accountId, $methodName, $methodCallId);
            } elseif (strcmp($methodCalls[0][0], "Identity/set") === 0) {
                $adapter = $this->dataAdapters["Settings"];
                $mapper = $this->dataMappers["Settings"];

                if (isset($methodCalls[0][1]->create) && !is_null($methodCalls[0][1]->create)) {
                    $contacts = $this->dataAccessors["Settings"]->set($methodCalls[0][1]->create);
                } else {
                    $msg = $this->errorInvalidArgument(
                        $methodCallId,
                        "Identity/Set currently requires create parameter."
                    );

                    die($msg);
                }

                $list = $mapper->mapToJmap($contacts, $adapter);

                echo $this->buildJmapSetResponse($created, $destroyed, $accountId, $methodName, $methodCallId);
            } else {
                echo $this->errorUnknownMethod($methodCallId);
            }
        } else {
            echo $this->errorUnknownCapability($using);
        }
    }


    private function returnJmapSessionResource()
    {
        // TODO: Implement me
    }

    private function buildJmapGetResponse($list, $accountId, $methodName, $methodCallId)
    {
        $args = array("state" => "someState", "list" => $list, "notFound" => [], "accountId" => $accountId);
        $invocation = array($methodName, $args, $methodCallId);
        $response = array("methodResponses" => array($invocation), "sessionState" => "someSessionState");

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    private function buildJmapSetResponse($createMap, $destroyMap, $accountId, $methodName, $methodCallId)
    {
        // TODO would be id/number values
        $newState = "1234";
        $created = [];
        $destroyed = [];
        $notCreated = [];
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

        if ($destroyMap) {
            foreach (array_keys($destroyMap) as $destroyId) {
                $success = $destroyMap[$destroyId];

                if ($success != 1) {
                    $setError = array(
                        "type" => "invalidProperties",
                        "description" => "There was an error when destroying the object");
                    $notDestroyed[$destroyId] = $setError;
                } else {
                    array_push($destroyed, $destroyId);
                }
            }
        }

        $args = array(
            "accountId" => $accountId,
            "newState" => $newState,
            "created" => $created,
            "destroyed" => $destroyed,
            "notCreated" => $notCreated,
            "notDestroyed" => $notDestroyed
        );
        $invocation = array($methodName, $args, $methodCallId);
        $response = array("methodResponses" => array($invocation), "sessionState" => "someSessionState");

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    private function buildJmapQueryResponse($list, $accountId, $methodName, $methodCallId)
    {
        $args = array(
            "queryState" => "someState",
            "ids" => $list,
            "notFound" => [],
            "accountId" => $accountId,
            "canCalculateChanges" => false,
            "position" => 0
        );
        $invocation = array($methodName, $args, $methodCallId);
        $content = array("methodResponses" => array($invocation), "sessionState" => "someSessionState");

        return json_encode($content, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    // Error-handling functions below
    // TODO: Should we keep them here or put them in a separate class for error-handling?
    private function errorInvalidArgument($methodCallId, $description)
    {
        $args = array("type" => "errorInvalidArgument", "description" => $description);
        $invocation = array("error", $args, $methodCallId);
        $content = array("methodResponses" => array($invocation), "sessionState" => "someSessionState");

        return json_encode($content, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    private function errorUnknownMethod($methodCallId)
    {
        $args = array("type" => "unknownMethod");
        $invocation = array("error", $args, $methodCallId);
        $response = array("methodResponses" => array($invocation), "sessionState" => "0");
        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    private function errorUnknownCapability($using)
    {
        $response = array(
            "type" => "urn:ietf:params:jmap:error:unknownCapability",
            "status" => 400,
            "detail" => "Unknown capability" . $using
        );

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    private function errorNotRequest()
    {
        $response = array(
            "type" => "urn:ietf:params:jmap:error:notRequest",
            "status" => 400,
            "detail" => "Not a valid JMAP request"
        );

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }
}
