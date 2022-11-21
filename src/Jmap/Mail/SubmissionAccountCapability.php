<?php

namespace OpenXPort\Jmap\Mail;

class SubmissionAccountCapability extends \OpenXPort\Jmap\Core\AccountCapability
{
    public function __construct()
    {
        $this->capabilities = array(
            'maxDelaySend' => 0,
            'submissionExtensions' => null,
        );
        $this->name = "urn:ietf:params:jmap:submission";
    }
}
