<?php

namespace OpenXPort\Util;

use Psr\Log\LogLevel;

/**
 * Simple file logger
 * based on https://github.com/wasinger/simplelogger/blob/master/Wa72/SimpleLogger
 */
class FileLogger extends AbstractSimpleLogger
{
    protected $logfile;

    /**
     * @param string $logfile Filename to log messages to (complete path)
     * @param string $minLevel
     */
    public function __construct($logfile, $minLevel = LogLevel::DEBUG)
    {
        if (!file_exists($logfile)) {
            if (!touch($logfile)) {
                throw new \InvalidArgumentException('Log file ' . $logfile . ' cannot be created');
            }
        }
        if (!is_writable($logfile)) {
            throw new \InvalidArgumentException('Log file ' . $logfile . ' is not writeable');
        }
        $this->logfile = $logfile;
        $this->minLevel = $minLevel;
        $this->uniqueid = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT']);
    }

    public function log($level, $message, array $context = array())
    {
        if (!$this->minLevelReached($level)) {
            return;
        }
        $logline = $this->format($level, $message, $context);
        file_put_contents($this->logfile, $logline, FILE_APPEND | LOCK_EX);
    }
}
