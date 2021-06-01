<?php

namespace OpenXPort\DataAccess;

/*
 * Data Accessors are for accessing the data of the underlying system.
 * They live one layer below the JMAP API.
 * Their actions depend on the JMAP Method called.
 */
abstract class AbstractDataAccess
{
    // Reads all entities
    abstract public function getAll($accountId = null);

    // Reads specific entities
    abstract public function get($ids, $accountId = null);

    // Creates specific entities
    abstract public function create($contactsToCreate, $accountId = null);

    // Destroys specific entities
    abstract public function destroy($ids, $accountId = null);

    // Collects multiple ids
    // TODO support multiple FilterConditions like in JMAP standard
    abstract public function query($accountId, $filter = null);
}
