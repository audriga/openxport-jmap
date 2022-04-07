<?php

namespace OpenXPort\Util;

use Psr\Log\LogLevel;

/**
 * Simple array logger
 * based on https://raw.githubusercontent.com/wasinger/simplelogger/master/Wa72/SimpleLogger/ArrayLogger.php
 */
class ArrayLogger extends AbstractSimpleLogger
{
    protected $memory = array();

    /**
     * @param string $minLevel
     */
    public function __construct($minLevel = LogLevel::DEBUG)
    {
        $this->minLevel = $minLevel;
    }

    public function log($level, $message, array $context = array())
    {
        if (!$this->minLevelReached($level)) {
            return;
        }

        $parentTraceline = $this->getParentTraceLine();

        $logLine = array(
            'level' => $level,
            'message' => $this->interpolate($message, $context),
            'timestamp' => gmdate("o-m-d\TH:i:s\Z")
        );

        if (array_key_exists('file', $parentTraceline)) {
            $path = explode('/', $parentTraceline['file']);
            $logLine['file'] = array_pop($path);
        }
        if (array_key_exists('line', $parentTraceline)) {
            $logLine['line'] = $parentTraceline['line'];
        }

        $this->memory[] = $logLine;
    }

    /**
     * Get all log entries
     *
     * @return array Array of associative log entry arrays with keys 'timestamp', 'level' and 'message'
     */
    public function getEntries()
    {
        return $this->memory;
    }

    /**
     * Clear the log
     *
     */
    public function clearEntries()
    {
        $this->memory = array();
    }
}
