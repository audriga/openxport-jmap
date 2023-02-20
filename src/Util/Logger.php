<?php

namespace OpenXPort\Util;

use Gelf\Transport\TcpTransport;

/**
 * Initializes and spits out a PSR-3 logger
 * TODO It might be a good idea to add console logging as fallback, since logging is required in openxport now.
 */
class Logger
{
    private static $logger;

    // Private constructor because
    private function __construct()
    {
    }

    /**
     * Initializes the logger depending on the request, config and included dependencies
     *
     * @author Joris Baum
     *
     * @param array $oxpConfig A map of the configuration
     * @param OpenXPort\Jmap\Core\Request $jmapRequest depending on the request we might want to log via API
     */
    public static function init($oxpConfig, $jmapRequest)
    {
        $logger = null;
        $graylogException = null;

        if ($jmapRequest && in_array("https://www.audriga.eu/jmap/debug/", $jmapRequest->getCapabilities())) {
            $logger = new ArrayLogger($oxpConfig["logLevel"]);
            $logger->info("Array Logger has been successfully initialized");
        } elseif ($oxpConfig["allowGraylog"] && class_exists('Gelf\Logger')) {
            try {
                // Try sending a log line first and raise exception in case of error
                if ($oxpConfig["graylogUseTls"]) {
                    $sslOptions = new \Gelf\Transport\SslOptions();

                    $sslOptions->setAllowSelfSigned($oxpConfig["graylogAllowSelfSigned"]);
                }

                $transport = new TcpTransport($oxpConfig["graylogEndpoint"], $oxpConfig["graylogPort"], $sslOptions);
                $uniqueId = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT']);

                $logger = new \Gelf\Logger($transport, null, array("request_id" => $uniqueId));

                $logger->info("Initializing...");

                // Ignore all future logging errors and init Logger
                $transport = new \Gelf\Transport\IgnoreErrorTransportWrapper($transport);
                $logger = new \Gelf\Logger($transport, null, array("request_id" => $uniqueId));

                $logger->info("Graylog Logger has been successfully initialized");
            } catch (exception $e) {
                $graylogException = $e;
            }
        }

        // Initialize file-based logger when Graylog is not included or exception has been raised
        if ($oxpConfig["allowFileLog"] && (!$logger || $graylogException)) {
            $logger = new FileLogger($oxpConfig["fileLogPath"], $oxpConfig["logLevel"]);

            $logger->info("File Logger has been successfully initialized");
            if ($graylogException) {
                // Log to file just like in Jmap\Core\ErrorHandler
                $logger->error(
                    "Exception raised when initializing Graylog. " .
                    "EXCEPTION " . $graylogException->getCode() . ":" .
                    " - Message " . $graylogException->getMessage() .
                    " - File " . $graylogException->getFile() .
                    " - Line " . $graylogException->getLine()
                );
            }
        }

        self::$logger = $logger;
    }

    /* Spit out logger that has been eaten
     * Fall back to DummyLogger instead
     * */
    public static function getInstance()
    {
        if (!self::$logger) {
            self::$logger = new \Psr\Log\NullLogger();
        }

        return self::$logger;
    }
}
