<?php

namespace OpenXPort\Jmap\Mail\Methods;

use OpenXPort\Jmap\Core\Invocation;
use OpenXPort\Jmap\Core\Method;
use OpenXPort\Jmap\Mail\EmailSubmission;

/**
 * Handles EmailSubmission/set (RFC 8621 section 7.5).
 *
 * Also supports onSuccessUpdateEmail, used by clients to move a sent draft into the
 * Sent mailbox in the same round trip.
 */
class EmailSubmissionSetMethod implements Method
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];

        $created = [];
        $notCreated = [];
        $destroyed = [];
        $notDestroyed = [];

        // maps creation id -> emailId, so onSuccessUpdateEmail's "#creationId" keys
        // can be resolved to the email they should be applied to
        $emailIdByCreationId = [];

        if (isset($arguments['create']) && !is_null($arguments['create'])) {
            $submissionsToCreate = [];
            foreach ((array) $arguments['create'] as $creationId => $data) {
                $submission = EmailSubmission::fromJson($data);
                $submissionsToCreate[$creationId] = $submission;
                $emailIdByCreationId[$creationId] = $submission->getEmailId();
            }

            $createResults = $dataAccessors['EmailSubmissions']->create($submissionsToCreate);

            foreach ($createResults as $creationId => $result) {
                if (empty($result)) {
                    $notCreated[$creationId] = [
                        'type' => 'invalidProperties',
                        'description' => 'Could not create the email submission'
                    ];
                    continue;
                }
                // server-set properties the client doesn't already know, per RFC 8621
                // section 7.4: id, threadId, sendAt, undoStatus
                $created[$creationId] = $result;
            }
        }

        if (isset($arguments['destroy']) && !is_null($arguments['destroy'])) {
            foreach ($dataAccessors['EmailSubmissions']->destroy($arguments['destroy']) as $id => $success) {
                if ($success) {
                    $destroyed[] = $id;
                } else {
                    $notDestroyed[$id] = [
                        'type' => 'notFound',
                        'description' => 'Could not find the email submission to destroy'
                    ];
                }
            }
        }

        if (isset($arguments['onSuccessUpdateEmail']) && !is_null($arguments['onSuccessUpdateEmail'])) {
            $emailUpdates = [];

            foreach ((array) $arguments['onSuccessUpdateEmail'] as $ref => $patch) {
                $creationId = ltrim($ref, '#');
                if (!isset($emailIdByCreationId[$creationId])) {
                    continue;
                }
                $emailUpdates[$emailIdByCreationId[$creationId]] = $patch;
            }

            if (!empty($emailUpdates)) {
                $dataAccessors['Emails']->update($emailUpdates);
            }
        }

        $args = [
            'accountId' => $accountId,
            'oldState' => null,
            'newState' => $dataAccessors['EmailSubmissions']->getCurrentState($accountId),
            'created' => empty($created) ? (object)[] : $created,
            'updated' => (object)[],
            'destroyed' => $destroyed,
            // left null (omitted by Invocation::jsonSerialize) rather than {} when empty:
            // an empty object is truthy in JS, so a client checking `if (notCreated)`
            // would misread {} as a failure
            'notCreated' => empty($notCreated) ? null : $notCreated,
            'notUpdated' => null,
            'notDestroyed' => empty($notDestroyed) ? null : $notDestroyed
        ];

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }
}
