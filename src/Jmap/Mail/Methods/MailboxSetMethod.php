<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;

class MailboxSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $created = [];
        $updated = [];
        $destroyed = [];

        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $created = $dataAccessors["Mailboxes"]->create((array) $arguments["create"]);
        }

        if (isset($arguments["update"]) && !is_null($arguments["update"])) {
            $updated = $dataAccessors["Mailboxes"]->update((array) $arguments["update"]);
        }

        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            $destroyed = $dataAccessors["Mailboxes"]->destroy($arguments["destroy"]);
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated);
    }
}
