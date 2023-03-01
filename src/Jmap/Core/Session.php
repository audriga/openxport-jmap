<?php

namespace OpenXPort\Jmap\Core;

use JsonSerializable;

class Session implements JsonSerializable
{
    private $capabilities;
    private $accounts;
    private $primaryAccounts;
    private $username;
    private $apiUrl;
    private $downloadUrl;
    private $eventSourceUrl;

    public function __construct($username = null)
    {
        $this->capabilities = array();

        // TODO pass through available accounts in future version
        $this->accounts = array();

        $this->primaryAccounts = array();

        // No support for Push
        $this->eventSourceUrl = "";

        $this->username = $username;
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
        $this->apiUrl .= rtrim($_SERVER['REQUEST_URI'], '/.well-known/jmap');

        return $this->apiUrl;
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
            "username" => $this->username,
            "apiUrl" => $this->getApiUrl(),
            "downloadUrl" => null,
            "uploadUrl" => null,
            "eventSourceUrl" => $this->eventSourceUrl,
            "state" => $state
        ];
    }
}
