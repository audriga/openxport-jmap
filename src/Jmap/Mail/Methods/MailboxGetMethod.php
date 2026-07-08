<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\GetMethod;

class MailboxGetMethod extends GetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $adapter = $dataAdapters["Mailboxes"];
        $mapper = $dataMappers["Mailboxes"];

        if (isset($arguments["ids"]) && !is_null($arguments["ids"])) {
            $mailboxes = $dataAccessors["Mailboxes"]->get($arguments["ids"]);
        } else {
            $mailboxes = $dataAccessors["Mailboxes"]->getAll();
        }

        $list = $mapper->mapToJmap($mailboxes, $adapter);

        return $this->buildMethodResponse($list, "", $methodCall);
    }
}
