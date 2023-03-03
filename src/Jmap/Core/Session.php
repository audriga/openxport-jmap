<?php

namespace OpenXPort\Jmap\Core;

use JsonSerializable;

class Session implements JsonSerializable
{
    private $logger;
    private $capabilities;
    private $accounts;
    private $primaryAccounts;
    private $username;
    private $apiUrl;
    private $downloadUrl;
    private $uploadUrl;
    private $eventSourceUrl;

    public function __construct($accounts, $primaryAccounts, $username = null, $uploadUrl = "", $downloadUrl = "")
    {
        $this->logger = \OpenXPort\Util\Logger::getInstance();
        $this->capabilities = array();

        $this->username = $username;

        // No support for Push
        $this->eventSourceUrl = "";

        if (!empty($uploadUrl)) {
            if (!strpos($uploadUrl, 'accountId')) {
                $this->logger->error("uploadUrl does not contain accountId");
            }
        }
        $this->uploadUrl = $uploadUrl;

        if (!empty($downloadUrl)) {
            if (!strpos($downloadUrl, 'accountId')) {
                $this->logger->error("downloadUrl does not contain accountId");
            }
            if (!strpos($downloadUrl, 'blobId')) {
                $this->logger->error("downloadUrl does not contain blobId");
            }
            if (!strpos($downloadUrl, 'type')) {
                $this->logger->error("downloadUrl does not contain type");
            }
            if (!strpos($downloadUrl, 'name')) {
                $this->logger->error("downloadUrl does not contain name");
            }
        }
        $this->downloadUrl = $downloadUrl;

        if (!isset($accounts) || empty($accounts)) {
            $this->logger->error("accounts is empty");
        }

        if (!isset($primaryAccounts) || empty($primaryAccounts)) {
            $this->logger->error("primaryAccounts is empty");
        }

        if (in_array("urn:ietf:params:jmap:core", array_keys($primaryAccounts))) {
            $this->logger->error("\"urn:ietf:params:jmap:core\" found as key in primaryAccounts");
        }

        $this->accounts = $accounts;
        $this->primaryAccounts = $primaryAccounts;
    }

     /**
     * Add a capability to the JMAP server
     *
     * @param Capability $capability Instance of the corresponding capability class
     * @return void
     */
    public function addCapability($capability)
    {
        $this->capabilities[$capability->getName()] = $capability;
    }

    /**
     * Calculate state via first part of SHA1 of serialized JSON object
     *
     * @return string
     */
    public function getState()
    {
        return mb_substr(sha1(serialize($this->jsonSerialize(false))), 0, 12);
    }

    public function getApiUrl()
    {
        if (!is_null($this->apiUrl)) {
            return $this->apiUrl;
        }

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $baseUrl = "https://";
        } else {
            $baseUrl = "http://";
        }
        $baseUrl .= $_SERVER['HTTP_HOST'];

        // Append the requested resource location to the URL
        // (and remove well-known in case its in)
        $this->apiUrl .= str_replace('/.well-known/jmap', '', $baseUrl . $_SERVER['REQUEST_URI']);


        return $this->apiUrl;
    }

    public function setDownloadUrl($downloadUrl)
    {
        $this->downloadUrl = $downloadUrl;
    }

    public function getDownloadUrl()
    {
        return $this->downloadUrl;
    }

    public function setUploadUrl($uploadUrl)
    {
        $this->uploadUrl = $uploadUrl;
    }

    public function getUploadUrl()
    {
        return $this->uploadUrl;
    }

    public function getAccounts()
    {
        return $this->accounts;
    }

    public function getPrimaryAccounts()
    {
        return $this->primaryAccounts;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Make sure we support all passed capabilities in $usedCapabilities and return an array of methods
     *
     * @param array $usedCapabilities array of capability names
     * @return array The values are full method names (e.g. "Email/get")
     */
    public function resolveMethods($usedCapabilities)
    {
        $methods = array();

        foreach ($usedCapabilities as $usedCapability) {
            // Make sure we do support the capability
            if (!array_key_exists($usedCapability, $this->capabilities)) {
                die(ErrorHandler::raiseUnknownCapability($usedCapability));
            }

            // Lookup capability methods
            $capability = $this->capabilities[$usedCapability];
            $methods = array_merge($methods, $capability->getMethods());
        }

        return $methods;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize($withState = true)
    {
        $state = $withState ? $this->getState() : null;
        return [
            "capabilities" => (object) $this->capabilities,
            "accounts" => (object) $this->accounts,
            "primaryAccounts" => (object) $this->primaryAccounts,
            "username" => $this->getUsername(),
            "apiUrl" => $this->getApiUrl(),
            "downloadUrl" => $this->getDownloadUrl(),
            "uploadUrl" => $this->uploadUrl,
            "eventSourceUrl" => $this->eventSourceUrl,
            "state" => $state
        ];
    }
}
