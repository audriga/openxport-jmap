<?php

namespace OpenXPort\Jmap\Note;

class NotesServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:notes";
    }

    public function getMethods()
    {
        return array(
            "Note/get" => Methods\NoteGetMethod::class,
            "Notebook/get" => Methods\NotebookGetMethod::class
        );
    }
}
