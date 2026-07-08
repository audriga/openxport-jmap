<?php

namespace OpenXPort\Jmap\Mail;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

/**
 * Email object as defined in RFC 8621 (JMAP for Mail).
 */
class Email implements JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $blobId;

    /** @var string */
    private $threadId;

    /** @var array<string, bool> */
    private $mailboxIds;

    /** @var array<string, bool> */
    private $keywords;

    /** @var int */
    private $size;

    /** @var string */
    private $receivedAt;

    /** @var string */
    private $subject;

    /** @var string */
    private $sentAt;

    /** @var bool */
    private $hasAttachment;

    /** @var string */
    private $preview;

    /** @var EmailAddress[] */
    private $sender;

    /** @var EmailAddress[] */
    private $from;

    /** @var EmailAddress[] */
    private $to;

    /** @var EmailAddress[] */
    private $cc;

    /** @var EmailAddress[] */
    private $bcc;

    /** @var EmailAddress[] */
    private $replyTo;

    /** @var array */
    private $textBody;

    /** @var array */
    private $htmlBody;

    /** @var array */
    private $attachments;

    /** @var array<string, array> */
    private $bodyValues;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getBlobId()
    {
        return $this->blobId;
    }

    public function setBlobId($blobId)
    {
        $this->blobId = $blobId;
    }

    public function getThreadId()
    {
        return $this->threadId;
    }

    public function setThreadId($threadId)
    {
        $this->threadId = $threadId;
    }

    public function getMailboxIds()
    {
        return $this->mailboxIds;
    }

    public function setMailboxIds($mailboxIds)
    {
        $this->mailboxIds = $mailboxIds;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getReceivedAt()
    {
        return $this->receivedAt;
    }

    public function setReceivedAt($receivedAt)
    {
        $this->receivedAt = $receivedAt;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSentAt()
    {
        return $this->sentAt;
    }

    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;
    }

    public function getHasAttachment()
    {
        return $this->hasAttachment;
    }

    public function setHasAttachment($hasAttachment)
    {
        $this->hasAttachment = $hasAttachment;
    }

    public function getPreview()
    {
        return $this->preview;
    }

    public function setPreview($preview)
    {
        $this->preview = $preview;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getCc()
    {
        return $this->cc;
    }

    public function setCc($cc)
    {
        $this->cc = $cc;
    }

    public function getBcc()
    {
        return $this->bcc;
    }

    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    public function getTextBody()
    {
        return $this->textBody;
    }

    public function setTextBody($textBody)
    {
        $this->textBody = $textBody;
    }

    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    public function setHtmlBody($htmlBody)
    {
        $this->htmlBody = $htmlBody;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    public function getBodyValues()
    {
        return $this->bodyValues;
    }

    public function setBodyValues($bodyValues)
    {
        $this->bodyValues = $bodyValues;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "id" => $this->getId(),
            "blobId" => $this->getBlobId(),
            "threadId" => $this->getThreadId(),
            "mailboxIds" => $this->getMailboxIds(),
            "keywords" => $this->getKeywords(),
            "size" => $this->getSize(),
            "receivedAt" => $this->getReceivedAt(),
            "subject" => $this->getSubject(),
            "sentAt" => $this->getSentAt(),
            "hasAttachment" => $this->getHasAttachment(),
            "preview" => $this->getPreview(),
            "sender" => $this->getSender(),
            "from" => $this->getFrom(),
            "to" => $this->getTo(),
            "cc" => $this->getCc(),
            "bcc" => $this->getBcc(),
            "replyTo" => $this->getReplyTo(),
            "textBody" => $this->getTextBody(),
            "htmlBody" => $this->getHtmlBody(),
            "attachments" => $this->getAttachments(),
            "bodyValues" => $this->getBodyValues()
        ], function ($val) {
            return !is_null($val);
        });
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        $this->subject = AdapterUtil::reencode($this->subject);
        $this->preview = AdapterUtil::reencode($this->preview);
    }
}
