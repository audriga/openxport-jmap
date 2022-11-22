<?php

namespace OpenXPort\Jmap\Core;

/**
 * Server class which serves as the main entry point of the JMAP Library.
 */
class Server
{
    private $dataAccessors;

    private $dataAdapters;

    private $dataMappers;

    private $logger;

    private $capMap = array(
        "calendars" => \OpenXPort\Jmap\Calendar\CalendarsServerCapability::class,
        "contacts" => \OpenXPort\Jmap\Contact\ContactsServerCapability::class,
        "debug" => \OpenXPort\Jmap\AudrigaDebug\AudrigaDebugServerCapability::class,
        "files" => \OpenXPort\Jmap\Files\FilesServerCapability::class,
        "mail" => \OpenXPort\Jmap\Mail\SubmissionServerCapability::class,
        "tasks" => \OpenXPort\Jmap\Tasks\TasksServerCapability::class,
        "notes" => \OpenXPort\Jmap\Note\NotesServerCapability::class,
        "sieve" => \OpenXPort\Jmap\SieveScript\SieveScriptsServerCapability::class,
        "jscontact" => \OpenXPort\Jmap\JSContact\ContactsServerCapability::class,
        "vacationResponse" => \OpenXPort\Jmap\Mail\VacationResponseServerCapability::class,
    );

    private $config;

    /**
     * The constructor method of the Server class
     *
     * @param AbstractDataAccess $dataAccessors The data access classes used for working with data
     * @param AbstractAdapter $dataAdapters The adapter classes used for data transformation
     * @param AbstractMapper $dataMappers The data mapper classes used for mapping data between formats
     */
    public function __construct($dataAccessors, $dataAdapters, $dataMappers, $config)
    {
        $this->dataAccessors = $dataAccessors;
        $this->dataAdapters = $dataAdapters;
        $this->dataMappers = $dataMappers;
        $this->logger = \OpenXPort\Util\Logger::getInstance();

        $this->config = $config;

        // Init session
        $this->session = new Session();

        $this->session->addCapability(new CoreServerCapability());
        foreach ($this->config['capabilities'] as $cap) {
            $this->session->addCapability(new $this->capMap[$cap]());
        }
    }

    /* Process JMAP request and return JSON response */
    public function handleJmapRequest($jmapRequest)
    {
        header('Content-Type: application/json');

        if (strcmp($_SERVER['REQUEST_METHOD'], "GET") === 0) {
            echo $this->serializeAsJson($this->session);
        } elseif (strcmp($_SERVER['REQUEST_METHOD'], "POST") === 0) {
            // Take JSON POST body and decode it in order to feed it into "Server::handleJmapRequest()"
            echo $this->handleJmapPostRequest($jmapRequest);
        }
    }

    /**
     * This method deals with receiving, analyzing and parsing/processing incoming JMAP requests
     *
     * @param OpenXPort\Jmap\Core\Request $request The JMAP request which is to be processed
     */
    private function handleJmapPostRequest($request)
    {
        $using = $request->getCapabilities();

        // Check for each capability in $using: Do we support it?
        $methodsAvailable = $this->session->resolveMethods($using);
        $responses = [];

        // For each method:
        // * Look if we and capability supports the method (iterate over methods of a certain capability)
        // * validate arguments of method
        // * return correct method response
        foreach ($request->getMethodCalls() as $methodCall) {
            $arguments = $methodCall->getArguments();
            $methodName = $methodCall->getName();

            $this->logger->info("Processing method call " . $methodName);

            try {
                // Resolve the method
                $method = $methodsAvailable[$methodName];
                if (!class_exists($method)) {
                    echo ErrorHandler::raiseUnknownMethod($methodCallId);
                    return;
                }

                // Execute the method
                $methodCallable = new $method();
                $methodResponse = $methodCallable->handle(
                    $methodCall,
                    $this->dataAccessors,
                    $this->dataAdapters,
                    $this->dataMappers
                );
                array_push($responses, $methodResponse);
            } catch (OutOfBoundsException $exception) {
                // TODO support multiple methods. push to array instead
                echo ErrorHandler::raiseUnknownMethod($methodCallId);
                return;
            }
        }

        // return response by concatenating method responses
        echo $this->buildResponse($responses);
        return;
    }

    /* Serialize as JSON, throw error on failure */
    private function serializeAsJson($content)
    {
        $json_response = json_encode($content, JSON_UNESCAPED_SLASHES);

        if ($json_response) {
            return $json_response;
        }

        $error = json_last_error();

        switch ($error) {
            case JSON_ERROR_NONE:
                break;
            case JSON_ERROR_DEPTH:
                $msg = 'Error during JSON encoding - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg = 'Error during JSON encoding - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg = 'Error during JSON encoding - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $msg = 'Error during JSON encoding - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $msg = 'Error during JSON encoding - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $msg = 'Error during JSON encoding - Unknown error';
                break;
        }

        $this->logger->warning($msg);

        \OpenXPort\Util\AdapterUtil::executeEncodingCallback();
        array_walk($content['methodResponses'][0][1]["list"], array('\OpenXPort\Util\AdapterUtil', 'sanitizeJson'));

        return json_encode($content, JSON_UNESCAPED_SLASHES);
    }

    private function buildResponse($invocations)
    {
        $response = new Response($invocations, $this->session);

        return $this->serializeAsJson($response);
    }
}
