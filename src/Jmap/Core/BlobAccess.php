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
     */
    abstract public function downloadBlob($path = null);

    /**
     * Uploads a blob (in JMAP terms this is binary data)
     *
     * @param string|null @path An optional path to the blob (useful for filesystem access)
     * @return boolean If upload is successful, return true, otherwise false
     */
    abstract public function uploadBlob($accountId, $path = null);

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
