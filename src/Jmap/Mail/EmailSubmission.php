<?php

namespace OpenXPort\Jmap\Mail;

use JsonSerializable;

/**
 * EmailSubmission object as defined in RFC 8621 (JMAP for Mail).
 */
class EmailSubmission implements JsonSerializable
{
    /** @var string|null */
    private $id;

    /** @var string|null */
    private $identityId;

    /** @var string|null */
    private $emailId;

    /** @var string|null */
    private $threadId;

    /** @var array|null */
    private $envelope;

    /** @var string|null */
    private $sendAt;

    /** @var string */
    private $undoStatus = 'final';

    /** @var array|null */
    private $deliveryStatus;

    /** @var array */
    private $dsnBlobIds = [];

    /** @var array */
    private $mdnBlobIds = [];

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdentityId()
    {
        return $this->identityId;
    }

    public function setIdentityId($identityId)
    {
        $this->identityId = $identityId;
    }

    public function getEmailId()
    {
        return $this->emailId;
    }

    public function setEmailId($emailId)
    {
        $this->emailId = $emailId;
    }

    public function getThreadId()
    {
        return $this->threadId;
    }

    public function setThreadId($threadId)
    {
        $this->threadId = $threadId;
    }

    public function getEnvelope()
    {
        return $this->envelope;
    }

    public function setEnvelope($envelope)
    {
        $this->envelope = $envelope;
    }

    public function getSendAt()
    {
        return $this->sendAt;
    }

    public function setSendAt($sendAt)
    {
        $this->sendAt = $sendAt;
    }

    public function getUndoStatus()
    {
        return $this->undoStatus;
    }

    public function setUndoStatus($undoStatus)
    {
        $this->undoStatus = $undoStatus;
    }

    public function getDeliveryStatus()
    {
        return $this->deliveryStatus;
    }

    public function setDeliveryStatus($deliveryStatus)
    {
        $this->deliveryStatus = $deliveryStatus;
    }

    public function getDsnBlobIds()
    {
        return $this->dsnBlobIds;
    }

    public function setDsnBlobIds($dsnBlobIds)
    {
        $this->dsnBlobIds = $dsnBlobIds;
    }

    public function getMdnBlobIds()
    {
        return $this->mdnBlobIds;
    }

    public function setMdnBlobIds($mdnBlobIds)
    {
        $this->mdnBlobIds = $mdnBlobIds;
    }

    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json, true);
        }
        if (is_array($json)) {
            $json = (object) $json;
        }

        $submission = new self();

        if (isset($json->identityId)) {
            $submission->setIdentityId($json->identityId);
        }
        if (isset($json->emailId)) {
            $submission->setEmailId($json->emailId);
        }
        if (isset($json->envelope)) {
            $submission->setEnvelope((array) $json->envelope);
        }
        if (isset($json->undoStatus)) {
            $submission->setUndoStatus($json->undoStatus);
        }

        return $submission;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            'id' => $this->getId(),
            'identityId' => $this->getIdentityId(),
            'emailId' => $this->getEmailId(),
            'threadId' => $this->getThreadId(),
            'envelope' => $this->getEnvelope(),
            'sendAt' => $this->getSendAt(),
            'undoStatus' => $this->getUndoStatus(),
            'deliveryStatus' => $this->getDeliveryStatus(),
            'dsnBlobIds' => $this->getDsnBlobIds(),
            'mdnBlobIds' => $this->getMdnBlobIds()
        ], function ($val) {
            return $val !== null;
        });
    }
}
