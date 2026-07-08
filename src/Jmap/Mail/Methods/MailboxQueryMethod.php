<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Methods\QueryMethod;

class MailboxQueryMethod extends QueryMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();

        $ids = $dataAccessors["Mailboxes"]->query($arguments["accountId"]);

        return $this->buildMethodResponse($ids, $methodCall);
    }
}
