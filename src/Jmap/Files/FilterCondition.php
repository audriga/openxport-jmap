<?php

namespace OpenXPort\Jmap\Files;

class FilterCondition extends \OpenXPort\Jmap\Core\FilterCondition
{
    /** @var string[] **/
    private $parentIds;

    /** @var string[] **/
    private $ancestorIds;

    /** @var boolean **/
    private $hasBlobId;

    /** @var DateTime **/
    private $createdBefore;

    /** @var DateTime **/
    private $createdAfter;

    /** @var DateTime **/
    private $modifiedBefore;

    /** @var DateTime **/
    private $modifiedAfter;

    /** @var int **/
    private $minSize;

    /** @var int **/
    private $maxSize;

    /** @var string **/
    private $name;

    /** @var string **/
    private $type;

    public function __construct($parentIds = null, $ancestorIds = null, $hasBlobId = null)
    {
        $this->parentIds = $parentIds;
        $this->ancestorIds = $ancestorIds;
        $this->hasBlobId = $hasBlobId;
    }

    public function setParentIds($parentIds)
    {
        $this->parentIds = $parentIds;
    }

    public function setAncestorIds($ancestorIds)
    {
        $this->ancestorIds = $ancestorIds;
    }

    public function setHasBlobId($hasBlobId)
    {
        $this->hasBlobId = $hasBlobId;
    }

    public function getParentIds()
    {
        return $this->parentIds;
    }

    public function getAncestorIds()
    {
        return $this->ancestorIds;
    }

    public function getHasBlobId()
    {
        return $this->hasBlobId;
    }
}
