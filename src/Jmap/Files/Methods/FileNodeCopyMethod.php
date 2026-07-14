<?php

namespace OpenXPort\Jmap\Files\Methods;

use OpenXPort\Jmap\Core\Invocation;

class FileNodeCopyMethod implements \OpenXPort\Jmap\Core\Method
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $accountId = $arguments['accountId'];
        $fromAccountId = isset($arguments['fromAccountId']) ? $arguments['fromAccountId'] : $accountId;
        $ifFromInState = isset($arguments['ifFromInState']) ? $arguments['ifFromInState'] : null;
        $filesToCopy = isset($arguments['create']) ? $arguments['create'] : [];

        $copied = [];
        $notCopied = [];

        foreach ($filesToCopy as $creationId => $copySpec) {
            try {
                $result = $dataAccessors['FileNodes']->copy($creationId, $copySpec, $fromAccountId, $accountId);
                if (isset($result[$creationId])) {
                    $copied[$creationId] = $result[$creationId];
                }
            } catch (\Exception $e) {
                $notCopied[$creationId] = ["type" => "serverFail", "description" => $e->getMessage()];
            }
        }

        $args = [
            "accountId" => $accountId,
            "fromAccountId" => $fromAccountId,
            "created" => $copied,
            "notCreated" => $notCopied,
        ];

        return new Invocation($methodCall->getName(), $args, $methodCall->getMethodCallId());
    }
}
