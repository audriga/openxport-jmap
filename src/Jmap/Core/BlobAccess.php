<?php

namespace OpenXPort\Jmap\Core;

/**
 * BlobAccess is an abstract class that provides a basis regarding
 * the different ways to access blobs (binary data) in a universal
 * fashion.
 *
 * Concrete classes need to extend this class and implement
 * its getBlob() method in the specific way that they desire (e.g.,
 * file system file access or webmailer-internal file access)
 */
abstract class BlobAccess
{
    /**
     * Downloads a blob (in JMAP terms this is binary data)
     *
     * @param string|null @path An optional path to the blob (useful for filesystem access)
     * @param bool $returnData When true, returns raw bytes as a string instead of streaming via HTTP
     */
    abstract public function downloadBlob($path = null, $returnData = false);

    /**
     * Uploads a blob (in JMAP terms this is binary data)
     *
     * @param string|null @path An optional path to the blob (useful for filesystem access)
     * @param string|null $data Raw bytes. When provided (JMAP Blob/upload method path), stores directly
     *                          and returns ['id', 'type', 'size']. When null, reads from php://input (HTTP path).
     * @param string|null $contentType MIME type of $data, echoed back as-is in the upload response.
     *                                 Ignored when $data is null.
     * @return array|boolean Returns blob metadata when $data is provided, otherwise true on success
     */
    abstract public function uploadBlob($accountId, $path = null, $data = null, $contentType = null);

    protected function buildUploadResponse($accountId, $blobId, $type, $size)
    {
        echo json_encode(
            array(
                "accountId" => $accountId,
                "blobId" => $blobId,
                "type" => $type,
                "size" => $size
            )
        );
    }

    // As per https://jmap.io/spec-core.html#uploading-binary-data when the upload of blobs (binary data)
    // was not successful, the server needs to return a JSON "problem details" object as the response body.
    // The JSON "problem details" object is defined in RFC 7807: https://datatracker.ietf.org/doc/html/rfc7807
    protected function buildProblemDetailsResponse(
        $type = null,
        $title = null,
        $status = null,
        $detail = null,
        $instance = null
    ) {
        echo json_encode(
            array(
                "type" => $type,
                "title" => $title,
                "status" => $status,
                "detail" => $detail,
                "instance" => $instance
            )
        );
    }
}
