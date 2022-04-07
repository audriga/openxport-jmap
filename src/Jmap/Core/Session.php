<?php

namespace OpenXPort\Jmap\Core;

use JsonSerializable;

class Session implements JsonSerializable
{
    private $capabilities;
    private $accounts;
    private $primaryAccounts;

    public function __construct()
    {
        $this->capabilities = array();

        // TODO pass through available accounts in future version
        $this->accounts = array();

        $this->primaryAccounts = array();
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
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $baseUrl = "https://";
        } else {
            $baseUrl = "http://";
        }
        $baseUrl .= $_SERVER['HTTP_HOST'];

        // Append the requested resource location to the URL
        $baseUrl .= $_SERVER['REQUEST_URI'];

        return $baseUrl;
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

    public function jsonSerialize($withState = true)
    {
        $state = $withState ? $this->getState() : null;
        return [
            "capabilities" => (object) $this->capabilities,
            "accounts" => (object) $this->accounts,
            "primaryAccounts" => (object) $this->primaryAccounts,
            "username" => null,
            "apiUrl" => $this->getApiUrl(),
            "downloadUrl" => null,
            "uploadUrl" => null,
            "eventSourceUrl" => null,
            "state" => $state
        ];
    }
}
