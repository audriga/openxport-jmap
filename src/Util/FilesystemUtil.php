<?php

namespace OpenXPort\Util;

use Exception;

/**
 * FileUtil is a class containing utility functions usually needed
 * when working with files and binary data. Examples for such scenarios
 * can be seen predominantly with JMAP blobs (binary data), as well as
 * with the JMAP type StorageNode which deals with files and directories.
 */
class FilesystemUtil
{
    /**
     * Returns the MIME type for a specified file
     *
     * @param string $pathToFile The full path to the file
     * @return string The MIME type of the file
     * @throws Exception If the specified file does not exist
     */
    public static function getMimeType($pathToFile)
    {
        if (!file_exists($pathToFile)) {
            throw new Exception("Specified file does not exist.");
        }

        return mime_content_type($pathToFile);
    }

    /**
     * Returns the full path to a specified file
     *
     * @param string $filesRootPath The root path under which files are stored
     * @param string $pathToFile The path to the file
     * @return string The full path to the file
     */
    public static function getFullPath($filesRootPath, $pathToFile)
    {
        return $filesRootPath . $pathToFile;
    }

    /**
     * Returns the size of a specified file
     *
     * @param string $pathToFile The path to the file
     * @return string The size of the file in bytes
     * @throws Exception If the specified file does not exist
     */
    public static function getSize($pathToFile)
    {
        if (!file_exists($pathToFile)) {
            throw new Exception("Specified file does not exist.");
        }

        $fileStats = stat($pathToFile);
        return $fileStats["size"];
    }
}
