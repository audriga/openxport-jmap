<?php

namespace OpenXPort\Jmap\Mail;

class MailServerCapability extends \OpenXPort\Jmap\Core\ServerCapability
{
    public function __construct()
    {
        $this->capabilities = array();
        $this->name = "urn:ietf:params:jmap:mail";
    }

    public function getMethods()
    {
        return array(
            "Mailbox/get" => Methods\MailboxGetMethod::class,
            "Mailbox/query" => Methods\MailboxQueryMethod::class,
            "Mailbox/set" => Methods\MailboxSetMethod::class,
            "Email/get" => Methods\EmailGetMethod::class,
            "Email/query" => Methods\EmailQueryMethod::class,
            "Email/set" => Methods\EmailSetMethod::class
        );
    }
}
