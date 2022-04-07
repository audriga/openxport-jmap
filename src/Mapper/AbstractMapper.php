<?php

namespace OpenXPort\Mapper;

/**
 * An abstract class which is to be inherited in order to provide logic for transforming
 * different types of data from and to JMAP data
 */
abstract class AbstractMapper
{
    /**
     *
     * @param mixed $data The JMAP data which is to be transformed into some other type of data
     * @param AbstractAdapter $adapter The adapter which transforms the JMAP data into some other type of data
     * @return mixed The data transformed from the JMAP data
     */
    abstract public function mapFromJmap($jmapData, $adapter);

    /**
     *
     * @param mixed $data The data which is to be transformed into JMAP data
     * @param AbstractAdapter $adapter The adapter which transforms the given data into JMAP data
     * @return mixed The JMAP data transformed from the given data
     */
    abstract public function mapToJmap($data, $adapter);
}
