<?php

namespace OpenXPort\Jmap\Core;

use Exception;
use OpenXPort\Util\FileUtil;

/**
 * BlobManagement is a class responsible for the handling of file download and upload
 * as per the JMAP Core specification regarding binary data, also known in JMAP as a blob.
 */
class BlobManagement
{
    /** @var BlobAccess[] */
    private $blobAccessors;

    private $logger;

    public function __construct($blobAccessors)
    {
        $this->blobAccessors = $blobAccessors;
        $this->logger = \OpenXPort\Util\Logger::getInstance();
    }

    // This function is currently copied from SquirrelMailStorageNodeDataAccess
    // with some modifications in it which remove the SquirrelMail-specific logic
    // previously contained in it
    public function downloadBlob($accountId, $name, $path, $accept)
    {
        // Inspiration was https://stackoverflow.com/a/32885706
        // Has more features like MIME type and ob_end_clean
        $mime_type = $accept;

        // Specified in JMAP Core
        header('Cache-Control: private, immutable, max-age=31536000');
        header('Content-Disposition: attachment; filename="' . $name . '"');

        // TODO raise error on incorrect MIME Type
        header('Content-Type: ' . $mime_type);

        // Own
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        // blobId is normally passed as the $path parameter that's why we take it from there
        $blobId = $path;

        // Check if the blobId is prefixed with 'sieve-'. If yes, we need to deliver a Sieve script blob,
        // otherwise a regular file blob
        if (substr($blobId, 0, 6) === "sieve-") {
            // Before passing $blobId to the the blob access class, make sure that we sanitize it from any prefixes
            $blobId = substr($blobId, 6);

            $this->blobAccessors["SieveScripts"]->downloadBlob($blobId);
        } elseif (substr($blobId, 0, 5) === "file-") {
            $blobId = substr($blobId, 5);

            $this->blobAccessors["Files"]->downloadBlob($blobId);
        } else {
            if (
                !isset($this->blobAccessors["Generic"])
                || is_null($this->blobAccessors["Generic"])
                || empty($this->blobAccessors["Generic"])
            ) {
                $this->logger->error("Generic Blob Access class not found");
                throw new Exception("No Generic Blob Access class defined");
            } else {
                $this->blobAccessors["Generic"]->downloadBlob($blobId);
            }
        }
    }

    public function uploadBlob($accountId, $path)
    {
        // blobId is normally passed as the $path parameter that's why we take it from there
        $blobId = $path;

        // Check if the blobId is prefixed with 'sieve-'. If yes, we need to upload a Sieve script blob,
        // otherwise a regular file blob
        if (substr($blobId, 0, 6) === "sieve-") {
            // Before passing $blobId to the the blob access class, make sure that we sanitize it from any prefixes
            $blobId = substr($blobId, 6);

            $this->blobAccessors["SieveScripts"]->uploadBlob(null, $blobId);
        } elseif (substr($blobId, 0, 5) === "file-") {
            $blobId = substr($blobId, 5);

            $this->blobAccessors["Files"]->uploadBlob(null, $blobId);
        } else {
            if (
                !isset($this->blobAccessors["Generic"])
                || is_null($this->blobAccessors["Generic"])
                || empty($this->blobAccessors["Generic"])
            ) {
                $this->logger->error("Generic Blob Access class not found");
                throw new Exception("No Generic Blob Access class defined");
            } else {
                $this->blobAccessors["Generic"]->uploadBlob($blobId);
            }
        }
    }
}
