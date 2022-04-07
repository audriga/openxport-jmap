<?php

namespace OpenXPort\Jmap\Note;

class NotesAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:notes";
    }
}
