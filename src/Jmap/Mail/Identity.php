<?php

namespace OpenXPort\Jmap\Mail;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class Identity implements JsonSerializable
{
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var EmailAddress[] */
    private $replyTo;

    /** @var EmailAddress[] */
    private $bcc;

    private $textSignature;

    private $htmlSignature;

    private $mayDelete;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    public function getBcc()
    {
        return $this->bcc;
    }

    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
    }

    public function getTextSignature()
    {
        return $this->textSignature;
    }

    public function setTextSignature($textSignature)
    {
        $this->textSignature = $textSignature;
    }

    public function getHtmlSignature()
    {
        return $this->htmlSignature;
    }

    public function setHtmlSignature($htmlSignature)
    {
        $this->htmlSignature = $htmlSignature;
    }

    public function getMayDelete()
    {
        return $this->mayDelete;
    }

    public function setMayDelete($mayDelete)
    {
        $this->mayDelete = $mayDelete;
    }

    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "replyTo" => $this->getReplyTo(),
            "bcc" => $this->getBcc(),
            "textSignature" => $this->getTextSignature(),
            "htmlSignature" => $this->getHtmlSignature(),
            "mayDelete" => $this->getMayDelete()
        ];
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        $this->name = AdapterUtil::reencode($this->name);
        $this->textSignature = AdapterUtil::reencode($this->textSignature);
        $this->htmlSignature = AdapterUtil::reencode($this->htmlSignature);
    }
}
