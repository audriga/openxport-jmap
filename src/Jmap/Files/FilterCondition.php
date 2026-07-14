<?php

namespace OpenXPort\Jmap\Files;

/**
 * Filter condition for FileNode/query as defined in the IETF JMAP FileNode spec
 * (draft-ietf-jmap-filenode / urn:ietf:params:jmap:filenode).
 *
 * @see https://www.ietf.org/archive/id/draft-ietf-jmap-filenode-14.txt Section 5 (Querying FileNodes)
 */
class FilterCondition extends \OpenXPort\Jmap\Core\FilterCondition
{
    /** @var string **/
    private $parentId;

    /** @var string **/
    private $ancestorId;

    /** @var string **/
    private $nodeType;

    /** @var string **/
    private $blobId;

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

    public function __construct()
    {
    }

    /**
     * Build a FilterCondition from a JSON object (stdClass).
     */
    public static function fromJson($filterConditionJson)
    {
        $filterCondition = new self();

        if (is_null($filterConditionJson)) {
            return $filterCondition;
        }

        $fields = [
            'parentId', 'ancestorId', 'nodeType', 'blobId',
            'createdBefore', 'createdAfter', 'modifiedBefore', 'modifiedAfter',
            'minSize', 'maxSize', 'name', 'type',
        ];

        foreach ($fields as $field) {
            if (isset($filterConditionJson->$field) && !is_null($filterConditionJson->$field)) {
                $setter = 'set' . ucfirst($field);
                $filterCondition->$setter($filterConditionJson->$field);
            }
        }

        return $filterCondition;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setAncestorId($ancestorId)
    {
        $this->ancestorId = $ancestorId;
    }

    public function getAncestorId()
    {
        return $this->ancestorId;
    }

    public function setNodeType($nodeType)
    {
        $this->nodeType = $nodeType;
    }

    public function getNodeType()
    {
        return $this->nodeType;
    }

    public function setBlobId($blobId)
    {
        $this->blobId = $blobId;
    }

    public function getBlobId()
    {
        return $this->blobId;
    }

    public function setCreatedBefore($createdBefore)
    {
        $this->createdBefore = $createdBefore;
    }

    public function getCreatedBefore()
    {
        return $this->createdBefore;
    }

    public function setCreatedAfter($createdAfter)
    {
        $this->createdAfter = $createdAfter;
    }

    public function getCreatedAfter()
    {
        return $this->createdAfter;
    }

    public function setModifiedBefore($modifiedBefore)
    {
        $this->modifiedBefore = $modifiedBefore;
    }

    public function getModifiedBefore()
    {
        return $this->modifiedBefore;
    }

    public function setModifiedAfter($modifiedAfter)
    {
        $this->modifiedAfter = $modifiedAfter;
    }

    public function getModifiedAfter()
    {
        return $this->modifiedAfter;
    }

    public function setMinSize($minSize)
    {
        $this->minSize = $minSize;
    }

    public function getMinSize()
    {
        return $this->minSize;
    }

    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function getMaxSize()
    {
        return $this->maxSize;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}
