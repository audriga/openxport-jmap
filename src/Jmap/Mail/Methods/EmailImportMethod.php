<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Invocation;
use OpenXPort\Jmap\Core\Method;

/**
 * Handles the Email/import JMAP method (RFC 8621 section 4.7).
 *
 * Adds an already-composed message, previously uploaded as a blob, to a mailbox.
 * Unlike Email/set create, the message content comes from the blob rather than
 * structured Email properties.
 */
class EmailImportMethod implements Method
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $emailsToImport = (array) ($arguments['emails'] ?? []);

        $created = [];
        $notCreated = [];

        foreach ($emailsToImport as $importId => $importSpec) {
            $importSpec = (array) $importSpec;
            $blobId = $importSpec['blobId'] ?? null;

            $rawMessage = $blobId !== null
                ? $dataAccessors['BlobManagement']->downloadBlob($accountId, null, $blobId, null, true)
                : null;

            if ($rawMessage === null) {
                $notCreated[$importId] = [
                    'type' => 'blobNotFound',
                    'description' => 'Could not find the referenced blob to import'
                ];
                continue;
            }

            $result = $dataAccessors['Emails']->import($importSpec, $rawMessage, $accountId);

            if (empty($result)) {
                $notCreated[$importId] = [
                    'type' => 'invalidProperties',
                    'description' => 'Could not import the email'
                ];
                continue;
            }

            $created[$importId] = $result;
        }

        $args = [
            'accountId' => $accountId,
            'oldState' => null,
            'newState' => $dataAccessors['Emails']->getCurrentState($accountId),
            'created' => empty($created) ? (object)[] : $created,
            'notCreated' => empty($notCreated) ? (object)[] : $notCreated
        ];

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }
}
