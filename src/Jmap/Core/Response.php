<?php

namespace Jmap\Core;

use JsonSerializable;

class Response implements JsonSerializable {

    // TODO: Possibly add a session object (Session.php) in order to be able to include a real session state in the response's JSON

    private $methodResponses;

    public function __construct($methodResponses) {
        $this->methodResponses = $methodResponses;
    }

    public function jsonSerialize() {
        return [
            "methodResponses" => $this->methodResponses,
            "createdIds" => (object)[],
            "sessionState" => null // TODO: possibly change this to be a legitimate session state instead of simply null
        ];
    }

}