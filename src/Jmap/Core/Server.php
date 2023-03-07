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
        "debug" => \OpenXPort\Jmap\Audriga\DebugServerCapability::class,
        "files" => \OpenXPort\Jmap\Files\FilesServerCapability::class,
        "mail" => \OpenXPort\Jmap\Mail\SubmissionServerCapability::class,
        "tasks" => \OpenXPort\Jmap\Tasks\TasksServerCapability::class,
        "notes" => \OpenXPort\Jmap\Note\NotesServerCapability::class,
        "sieve" => \OpenXPort\Jmap\SieveScript\SieveScriptsServerCapability::class,
        "jscontact" => \OpenXPort\Jmap\JSContact\ContactsServerCapability::class,
        "vacationResponse" => \OpenXPort\Jmap\Mail\VacationResponseServerCapability::class,
        "preferences" => \OpenXPort\Jmap\Preferences\PreferencesServerCapability::class
    );

    private $preferencesSubCapMap = array(
        "forwards" => \OpenXPort\Jmap\Preferences\ForwardsSubCapability::class,
        "blocklist" => \OpenXPort\Jmap\Preferences\BlocklistSubCapability::class
    );

    private $config;

    /** @var Session */
    private $session;

    /**
     * The constructor method of the Server class
     *
     * @param \OpenXPort\DataAccess\AbstractDataAccess[] $dataAccessors
     * The data access classes used for working with data
     *
     * @param \OpenXPort\Adapter\AbstractAdapter[] $dataAdapters
     * The adapter classes used for data transformation
     *
     * @param \OpenXPort\Mapper\AbstractMapper[] $dataMappers
     * The data mapper classes used for mapping data between formats
     */
    public function __construct($dataAccessors, $dataAdapters, $dataMappers, $config, $session = null)
    {
        $this->dataAccessors = $dataAccessors;
        $this->dataAdapters = $dataAdapters;
        $this->dataMappers = $dataMappers;
        $this->logger = \OpenXPort\Util\Logger::getInstance();

        $this->config = $config;

        // Complain in case the provided session obect is null
        if (is_null($session)) {
            $this->logger->warning("The provided session object is null.");
            $this->session = new \OpenXPort\Jmap\Core\Session();
        } else {
            $this->session = $session;
        }

        $this->session->addCapability(new CoreServerCapability());

        // Split capabilities into subCapabilities and actual capabilities
        // We want the user to be able to configure each sub Capability in a similar fashion as a normal capability
        $capabilities = array();
        $preferencesCapabilities = array();

        foreach ($this->config['capabilities'] as $cap) {
            if (in_array($cap, array_keys($this->preferencesSubCapMap))) {
                    array_push($preferencesCapabilities, new $this->preferencesSubCapMap[$cap]());
            } else {
                array_push($capabilities, $cap);
            }
        }

        // Init capabilities
        foreach ($capabilities as $cap) {
            $this->session->addCapability(new $this->capMap[$cap]());

            // We also add our own extension for VacationResponse
            // TODO support leaving out our extension in future
            if ($cap == "vacationResponse") {
                $this->session->addCapability(new \OpenXPort\Jmap\Audriga\VacationResponseServerCapability());
            }

            // Also add contacts capability in case jscontact is configured
            // TODO this is a workaround as long as we need to support jscontact
            if ($cap == "jscontact") {
                $this->session->addCapability(new \OpenXPort\Jmap\Contact\ContactsServerCapability());
            }
        }

        // Init capabilities with sub-capabilities
        $this->session->addCapability(new $this->capMap["preferences"]($preferencesCapabilities));
    }

    /* Process JMAP request and return JSON response */
    public function handleJmapRequest($jmapRequest)
    {
        header('Content-Type: application/json');

        if (strcmp($_SERVER['REQUEST_METHOD'], "GET") === 0) {
            $this->logger->info("Returning session.");
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
                if (is_null($method) || !class_exists($method)) {
                    echo ErrorHandler::raiseUnknownMethod($methodCall->getMethodCallId());
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
            } catch (\OutOfBoundsException $exception) {
                // TODO support multiple methods. push to array instead
                echo ErrorHandler::raiseUnknownMethod($methodCall->getMethodCallId());
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
