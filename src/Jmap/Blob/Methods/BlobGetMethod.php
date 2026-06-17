<?php

namespace OpenXPort\Jmap\Blob\Methods;

use OpenXPort\Jmap\Core\Method;

/**
 * Handles the Blob/get JMAP method (urn:ietf:params:jmap:blob).
 *
 * The IETF spec lets clients retrieve blob content by blobId directly inside a JMAP
 * request, instead of downloading via the HTTP downloadUrl. Returns the data as base64
 * so any JMAP type can read back what was previously uploaded with Blob/upload.
 *
 * @see https://www.ietf.org/archive/id/draft-ietf-jmap-blob-14.txt
 */
class BlobGetMethod implements Method
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $args = $methodCall->getArguments();
        $accountId = isset($args['accountId']) ? $args['accountId'] : null;
        $ids = isset($args['ids']) ? $args['ids'] : [];

        $list = [];
        $notFound = [];

        foreach ($ids as $id) {
            $data = $dataAccessors['BlobManagement']->downloadBlob($accountId, null, $id, null, true);
            if ($data !== null) {
                $entry = [
                    'id' => $id,
                    'data:asBase64' => base64_encode($data),
                    'size' => strlen($data),
                    'type' => 'application/octet-stream'
                ];
                if (mb_check_encoding($data, 'UTF-8')) {
                    $entry['data:asText'] = $data;
                }
                $list[] = $entry;
            } else {
                $notFound[] = $id;
            }
        }

        return [
            'Blob/get',
            ['accountId' => $accountId, 'list' => $list, 'notFound' => $notFound],
            $methodCall->getMethodCallId()
        ];
    }
}
