<?php

namespace OpenXPort\Util;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * Simple file logger
 * based on https://github.com/wasinger/simplelogger/blob/master/Wa72/SimpleLogger
 */
abstract class AbstractSimpleLogger extends AbstractLogger
{
    protected $minLevel;
    protected $levels = [
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::CRITICAL,
        LogLevel::ALERT,
        LogLevel::EMERGENCY
    ];
    protected $uniqueid;

    /**
     * @param string $level
     * @return boolean
     */
    protected function minLevelReached($level)
    {
        return \array_search($level, $this->levels) >= \array_search($this->minLevel, $this->levels);
    }

    /**
     * Returns the file and line which called the logging function
     *
     * This functions finds the deepest trace line that calls AbstractLogger and
     * goes back even further if file is not present in the line
     *
     * @author Joris Baum
     *
     * @return string
     */
    protected function getParentTraceLine()
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);

        while ($backtrace[0]['class'] != "Psr\Log\AbstractLogger") {
            array_shift($backtrace);
        }

        while (count($backtrace) > 1 && !array_key_exists('file', $backtrace[0])) {
            array_shift($backtrace);
        }

        return $backtrace[0];
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @author PHP Framework Interoperability Group
     *
     * @param string $message
     * @param array $context
     * @return string
     */
    protected function interpolate($message, array $context)
    {
        if (false === strpos($message, '{')) {
            return $message;
        }

        $replacements = array();
        foreach ($context as $key => $val) {
            if (null === $val || is_scalar($val) || (\is_object($val) && method_exists($val, '__toString'))) {
                $replacements["{{$key}}"] = $val;
            } elseif ($val instanceof \DateTimeInterface) {
                $replacements["{{$key}}"] = $val->format(\DateTime::RFC3339);
            } elseif (\is_object($val)) {
                $replacements["{{$key}}"] = '[object ' . \get_class($val) . ']';
            } else {
                $replacements["{{$key}}"] = '[' . \gettype($val) . ']';
            }
        }

        return strtr($message, $replacements);
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     * @param string|null $timestamp A Timestamp string in UTCDate format (RFC3339, e.g. '2022-01-17T11:33:35+00:00'),
     *   defaults to current time
     * @return string
     */
    protected function format($level, $message, $context, $timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = gmdate("o-m-d\TH:i:s\Z");
        }

        $level = strtoupper($level);

        $msg = $this->interpolate($message, $context);

        $parentTraceline = $this->getParentTraceLine();

        $file = 'UnknownFile';
        $line = '0';

        if (array_key_exists('file', $parentTraceline)) {
            $path = explode('/', $parentTraceline['file']);
            $file = array_pop($path);
        }
        if (array_key_exists('line', $parentTraceline)) {
            $line = $parentTraceline['line'];
        }

        return '[' . $timestamp . '] (' . $this->uniqueid . ', ' . $file . ', ' . $line . ') ' .  $level . ': ' .
            $msg . "\n";
    }
}
