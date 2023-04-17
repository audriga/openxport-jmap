<?php

namespace OpenXPort\Jmap\Core;

/**
 * Provides various Error outputs and ability to register error/exception hanlders.
 */
class ErrorHandler
{
    // NOTE: Do not use verbose output on public-facing setups. This may leak debug info via API.
    private $verboseOutput;

    public function __construct($verboseOutput = true)
    {
        $this->verboseOutput = $verboseOutput;
    }
    /**
     * Checks for a fatal error, work around for set_error_handler not working on fatal errors.
     */
    public function checkForFatal()
    {
        $error = error_get_last();
        if (in_array($error["type"], array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_RECOVERABLE_ERROR))) {
            $output = "";
            if ($this->verboseOutput) {
                $output = "ERROR " . $error["type"] . ":" .
                " - Message: " . $error["message"] .
                " - File " . $error["file"] .
                " - Line " . $error["line"];
            } else {
                $output = $error["message"];
            }
            die(self::raiseServerFail(
                0,  // TODO support methodCallId somehow in the future
                $output
            ));
        }
    }

    public function exceptionsErrorHandler($severity, $message, $filename, $lineno)
    {
        // Obtain an instance of the logger which is currently at use by us (i.e. our own logger and not the one from
        // PHP's internal logging)
        // Use this logger below to log to our own destinations, like log files or Graylog
        $logger = \OpenXPort\Util\Logger::getInstance();

        switch ($severity) {
            // Check if we're dealing with some type of error and if yes -> log with level ERROR
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                $logger->error($message, array());
                break;
            // Check if we're dealing with some type of warning and if yes -> log with level WARNING
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                $logger->warning($message, array());
        }

        // NOTE: The two elseif cases below are currently commented out, since we do not want to include
        // any NOTICE or INFO logs in production for now (so as to not clutter with too much logs)

        // Check if we're dealing with a notice and if yes -> log with level NOTICE
        // } elseif (in_array($severity, array(E_NOTICE, E_USER_NOTICE))) {
        //     $logger->notice($message, array());
        // // For the rest of the cases like deprecation warnings and PHP code suggestion, set log level to INFO
        // } elseif (in_array($severity, array(E_STRICT, E_DEPRECATED, E_USER_DEPRECATED))) {
        //     $logger->info($message, array());
        // }


        if (in_array($severity, array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_RECOVERABLE_ERROR))) {
            throw new \ErrorException($message, 0, $severity, $filename, $lineno);
        }

        # Forward to internal error handler
        return false;
    }

    public function exceptionHandler($exception)
    {
        $output = "";
        if ($this->verboseOutput) {
            $output = "EXCEPTION " . $exception->getCode() . ":" .
            " - Message " . $exception->getMessage() .
            " - File " . $exception->getFile() .
            " - Line " . $exception->getLine();
        } else {
            $output = $exception->getMessage();
        }

        echo self::raiseServerFail(
            0,  // TODO support methodCallId somehow in the future
            $output
        );
    }

    /* Sets the internal PHP exception and error handlers
     * NOTE: Do not use for public deployments. This will output debug info via API.
     * NOTE 2: In most cases it makes sense to run setHandlers() at the beginning of the jmap.php file, because some
     * webmailers require registering their own shutdown function.
     * */
    public function setHandlers()
    {
        set_exception_handler(array($this, 'exceptionHandler'));
        set_error_handler(array($this, 'exceptionsErrorHandler'));
        register_shutdown_function(array($this, 'checkForFatal'));
    }

    // request-level errors
    public static function raiseUnknownCapability($using)
    {
        $status_code = 400;
        http_response_code($status_code);

        $response = array(
            "type" => "urn:ietf:params:jmap:error:unknownCapability",
            "status" => $status_code,
            "detail" => "Unknown capability " . $using
        );

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    public static function raiseNotRequest()
    {
        $status_code = 400;
        http_response_code($status_code);

        $response = array(
            "type" => "urn:ietf:params:jmap:error:notRequest",
            "status" => $status_code,
            "detail" => "Not a valid JMAP request"
        );

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    // method-level errors
    public static function buildMethodResponse($methodCallId, $args)
    {
        $invocation = array("error", $args, $methodCallId);

        return array("methodResponses" => array($invocation), "sessionState" => "");
    }

    /* Generic error output used by exception handler */
    public static function raiseServerFail($methodCallId, $description)
    {
        http_response_code(500);

        $args = array("type" => "serverFail", "description" => $description);
        $response = self::buildMethodResponse($methodCallId, $args);

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    public static function raiseInvalidArgument($methodCallId, $description)
    {
        http_response_code(500);

        $args = array("type" => "invalidArguments", "description" => $description);
        $response = self::buildMethodResponse($methodCallId, $args);

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }

    public static function raiseUnknownMethod($methodCallId)
    {
        http_response_code(500);

        $args = array("type" => "unknownMethod");

        $response = self::buildMethodResponse($methodCallId, $args);

        return json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    }
}
