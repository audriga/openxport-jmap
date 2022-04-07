<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class Task implements JsonSerializable
{
    private $id;
    private $taskListId;
    private $isDraft;
    private $utcStart;
    private $utcDue;
    private $sortOrder;
    private $due;
    private $start;
    private $estimatedDuration;
    private $percentComplete;
    private $progress;
    private $progressUpdated;
    private $type; // this is serialized as "@type" in JSON
    private $uid;
    private $relatedTo;
    private $prodId;
    private $created;
    private $updated;
    private $sequence;
    private $method;
    private $title;
    private $description;
    private $descriptionContentType;
    private $showWithoutTime;
    private $locations;
    private $virtualLocations;
    private $links;
    private $locale;
    private $keywords;
    private $categories;
    private $color;
    private $recurrenceId;
    private $recurrenceRules;
    private $excludedRecurrenceRules;
    private $recurrenceOverrides;
    private $excluded;
    private $priority;
    private $freeBusyStatus;
    private $privacy;
    private $replyTo;
    private $participants;
    private $useDefaultAlerts;
    private $alerts;
    private $localizations;
    private $timeZone;
    private $timeZones;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTaskListId()
    {
        return $this->taskListId;
    }

    public function setTaskListId($taskListId)
    {
        $this->taskListId = $taskListId;
    }

    public function getIsDraft()
    {
        return $this->isDraft;
    }

    public function setIsDraft($isDraft)
    {
        $this->isDraft = $isDraft;
    }

    public function getUtcStart()
    {
        return $this->utcStart;
    }

    public function setUtcStart($utcStart)
    {
        $this->utcStart = $utcStart;
    }

    public function getUtcDue()
    {
        return $this->utcDue;
    }

    public function setUtcDue($utcDue)
    {
        $this->utcDue = $utcDue;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getDue()
    {
        return $this->due;
    }

    public function setDue($due)
    {
        $this->due = $due;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getEstimatedDuration()
    {
        return $this->estimatedDuration;
    }

    public function setEstimatedDuration($estimatedDuration)
    {
        $this->estimatedDuration = $estimatedDuration;
    }

    public function getPercentComplete()
    {
        return $this->percentComplete;
    }

    public function setPercentComplete($percentComplete)
    {
        $this->percentComplete = $percentComplete;
    }

    public function getProgress()
    {
        return $this->progress;
    }

    public function setProgress($progress)
    {
        $this->progress = $progress;
    }

    public function getProgressUpdated()
    {
        return $this->progressUpdated;
    }

    public function setProgressUpdated($progressUpdated)
    {
        $this->progressUpdated = $progressUpdated;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function getProdId()
    {
        return $this->prodId;
    }

    public function setProdId($prodId)
    {
        $this->prodId = $prodId;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescriptionContentType()
    {
        return $this->descriptionContentType;
    }

    public function setDescriptionContentType($descriptionContentType)
    {
        $this->descriptionContentType = $descriptionContentType;
    }

    public function getShowWithoutTime()
    {
        return $this->showWithoutTime;
    }

    public function setShowWithoutTime($showWithoutTime)
    {
        $this->showWithoutTime = $showWithoutTime;
    }

    public function getLocations()
    {
        return $this->locations;
    }

    public function setLocations($locations)
    {
        $this->locations = $locations;
    }

    public function getVirtualLocations()
    {
        return $this->virtualLocations;
    }

    public function setVirtualLocations($virtualLocations)
    {
        $this->virtualLocations = $virtualLocations;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function setLinks($links)
    {
        $this->links = $links;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getRecurrenceId()
    {
        return $this->recurrenceId;
    }

    public function setRecurrenceId($recurrenceId)
    {
        $this->recurrenceId = $recurrenceId;
    }

    public function getRecurrenceRules()
    {
        return $this->recurrenceRules;
    }

    public function setRecurrenceRules($recurrenceRules)
    {
        $this->recurrenceRules = $recurrenceRules;
    }

    public function getExcludedRecurrenceRules()
    {
        return $this->excludedRecurrenceRules;
    }

    public function setExcludedRecurrenceRules($excludedRecurrenceRules)
    {
        $this->excludedRecurrenceRules = $excludedRecurrenceRules;
    }

    public function getRecurrenceOverrides()
    {
        return $this->recurrenceOverrides;
    }

    public function setRecurrenceOverrides($recurrenceOverrides)
    {
        $this->recurrenceOverrides = $recurrenceOverrides;
    }

    public function getExcluded()
    {
        return $this->excluded;
    }

    public function setExcluded($excluded)
    {
        $this->excluded = $excluded;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getFreeBusyStatus()
    {
        return $this->freeBusyStatus;
    }

    public function setFreeBusyStatus($freeBusyStatus)
    {
        $this->freeBusyStatus = $freeBusyStatus;
    }

    public function getPrivacy()
    {
        return $this->privacy;
    }

    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    public function getParticipants()
    {
        return $this->participants;
    }

    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    public function getUseDefaultAlerts()
    {
        return $this->useDefaultAlerts;
    }

    public function setUseDefaultAlerts($useDefaultAlerts)
    {
        $this->useDefaultAlerts = $useDefaultAlerts;
    }

    public function getAlerts()
    {
        return $this->alerts;
    }

    public function setAlerts($alerts)
    {
        $this->alerts = $alerts;
    }

    public function getLocalizations()
    {
        return $this->localizations;
    }

    public function setLocalizations($localizations)
    {
        $this->localizations = $localizations;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public function getTimeZones()
    {
        return $this->timeZones;
    }

    public function setTimeZones($timeZones)
    {
        $this->timeZones = $timeZones;
    }

    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "taskListId" => $this->getTaskListId(),
            "isDraft" => $this->getIsDraft(),
            "utcStart" => $this->getUtcStart(),
            "utcDue" => $this->getUtcDue(),
            "sortOrder" => $this->getSortOrder(),
            "due" => $this->getDue(),
            "start" => $this->getStart(),
            "estimatedDuration" => $this->getEstimatedDuration(),
            "percentComplete" => $this->getPercentComplete(),
            "progress" => $this->getProgress(),
            "progressUpdated" => $this->getProgressUpdated(),
            "@type" => $this->getType(),
            "uid" => $this->getUid(),
            "relatedTo" => $this->getRelatedTo(),
            "prodId" => $this->getProdId(),
            "created" => $this->getCreated(),
            "updated" => $this->getUpdated(),
            "sequence" => $this->getSequence(),
            "method" => $this->getMethod(),
            "title" => $this->getTitle(),
            "description" => $this->getDescription(),
            "descriptionContentType" => $this->getDescriptionContentType(),
            "showWithoutTime" => $this->getShowWithoutTime(),
            "locations" => $this->getLocations(),
            "virtualLocations" => $this->getVirtualLocations(),
            "links" => $this->getLinks(),
            "locale" => $this->getLocale(),
            "keywords" => $this->getKeywords(),
            "categories" => $this->getCategories(),
            "color" => $this->getColor(),
            "recurrenceId" => $this->getRecurrenceId(),
            "recurrenceRules" => $this->getRecurrenceRules(),
            "excludedRecurrenceRules" => $this->getExcludedRecurrenceRules(),
            "recurrenceOverrides" => $this->getRecurrenceOverrides(),
            "excluded" => $this->getExcluded(),
            "priority" => $this->getPriority(),
            "freeBusyStatus" => $this->getFreeBusyStatus(),
            "privacy" => $this->getPrivacy(),
            "replyTo" => $this->getReplyTo(),
            "participants" => $this->getParticipants(),
            "useDefaultAlerts" => $this->getUseDefaultAlerts(),
            "alerts" => $this->getAlerts(),
            "localizations" => $this->getLocalizations(),
            "timeZone" => $this->getTimeZone(),
            "timeZones" => $this->getTimeZones()
        ];
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        if ($this->locations) {
            foreach ($this->locations as $id => $loc) {
                $loc->sanitizeFreeText();
            }
        }
        if ($this->virtualLocations) {
            foreach ($this->virtualLocations as $id => $loc) {
                $loc->sanitizeFreeText();
            }
        }
        if ($this->links) {
            foreach ($this->links as $id => $lin) {
                $lin->sanitizeFreeText();
            }
        }
        if ($this->recurrenceOverrides) {
            foreach ($this->recurrenceOverrides as $id => $rec) {
                $rec->sanitizeFreeText();
            }
        }

        $this->title = AdapterUtil::reencode($this->title);
        $this->description = AdapterUtil::reencode($this->description);
        $this->keywords = AdapterUtil::reencode($this->keywords);
    }
}
