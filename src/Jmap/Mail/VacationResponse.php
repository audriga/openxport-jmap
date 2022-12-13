<?php

namespace OpenXPort\Jmap\Mail;

use JsonSerializable;

class VacationResponse implements JsonSerializable
{
    /** @var string $id */
    private $id;

    /** @var bool $isEnabled */
    private $isEnabled;

    /** @var string|null $fromDate */
    private $fromDate;

    /** @var string|null $toDate */
    private $toDate;

    /** @var string|null $subject */
    private $subject;

    /** @var string|null $textBody */
    private $textBody;

    /** @var string|null $htmlBody */
    private $htmlBody;

    /** @var string|null $timeBetweenResponses */
    private $timeBetweenResponses;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    public function getFromDate()
    {
        return $this->fromDate;
    }

    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }

    public function getToDate()
    {
        return $this->toDate;
    }

    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
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

    public function getTimeBetweenResponses()
    {
        return $this->timeBetweenResponses;
    }

    public function setTimeBetweenResponses($time)
    {
        $this->timeBetweenResponses = $time;
    }

    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "isEnabled" => $this->getIsEnabled(),
            "fromDate" => $this->getFromDate(),
            "toDate" => $this->getToDate(),
            "subject" => $this->getSubject(),
            "textBody" => $this->getTextBody(),
            "htmlBody" => $this->getHtmlBody(),
            "timeBetweenResponses" => $this->getTimeBetweenResponses()
        ];
    }
}
