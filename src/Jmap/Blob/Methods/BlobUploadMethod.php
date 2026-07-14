<?php

namespace OpenXPort\Jmap\Blob\Methods;

use OpenXPort\Jmap\Core\Method;

/**
 * Handles the Blob/upload JMAP method (urn:ietf:params:jmap:blob).
 *
 * The IETF spec lets clients upload binary data inline inside a JMAP request as base64
 * or plain text chunks, instead of using the HTTP uploadUrl. The returned blobId can
 * then be used in any other JMAP method like FileNode/set or Email/set.
 *
 * @see https://www.ietf.org/archive/id/draft-ietf-jmap-blob-14.txt
 */
class BlobUploadMethod implements Method
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $args = $methodCall->getArguments();
        $accountId = isset($args['accountId']) ? $args['accountId'] : null;
        $createSpecs = isset($args['create']) ? (array) $args['create'] : [];

        $created = [];
        foreach ($createSpecs as $cid => $spec) {
            $data = '';
            $specArr = (array) $spec;
            $chunks = isset($specArr['data']) ? $specArr['data'] : [];
            foreach ($chunks as $chunk) {
                $chunk = (array) $chunk;
                if (isset($chunk['data:asText'])) {
                    $data .= $chunk['data:asText'];
                } elseif (isset($chunk['data:asBase64'])) {
                    $data .= base64_decode($chunk['data:asBase64']);
                }
            }
            $result = $dataAccessors['BlobManagement']->uploadBlob($accountId, null, $data);
            $created[$cid] = $result;
        }

        return [
            'Blob/upload',
            ['accountId' => $accountId, 'created' => $created],
            $methodCall->getMethodCallId()
        ];
    }
}
