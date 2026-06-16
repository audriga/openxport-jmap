<?php

namespace OpenXPort\Jmap\Files;

use OpenXPort\Util\AdapterUtil;

class FileNode implements \JsonSerializable
{
    /**
     * @var string is either ID or root, trash or temp
     * **/
    private $id;

    /** @var string **/
    private $parentId;

    /** @var string **/
    private $blobId;

    /** @var string **/
    private $name;

    /**
     * Content type
     * @var string
     * **/
    private $type;

    /** @var int **/
    private $size;

    /** @var int **/
    private $created;

    /** @var int **/
    private $modified;

    /** @var int **/
    private $accessed;

    /** Metadata-change timestamp, separate from modified
     * @var int **/
    private $changed;

    /**
     * One of "file", "folder", "symlink"
     * Replaces the legacy hasBlobId boolean
     * @var string
     * **/
    private $nodeType;

    /**
     * Well-known role for special folders (e.g. "home", "documents", "downloads",
     * "music", "pictures", "videos"). Set by the adapter from config.
     * @var string
     * **/
    private $role;

    /** @var bool **/
    private $executable;

    /** @var bool **/
    private $isSubscribed;

    /** @var object Permissions of the current user (mayRead, mayWrite, mayDelete, mayRename, maySetPermissions) **/
    private $myRights;

    /** @var object Map of principal ID to rights object (sharing configuration) **/
    private $shareWith;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
    }

    public function getBlobId()
    {
        return $this->blobId;
    }

    public function setBlobId($id)
    {
        $this->blobId = $id;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getModified()
    {
        return $this->modified;
    }

    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    public function getAccessed()
    {
        return $this->accessed;
    }

    public function setAccessed($accessed)
    {
        $this->accessed = $accessed;
    }

    public function getChanged()
    {
        return $this->changed;
    }

    public function setChanged($changed)
    {
        $this->changed = $changed;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getNodeType()
    {
        return $this->nodeType;
    }

    public function setNodeType($nodeType)
    {
        $this->nodeType = $nodeType;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getExecutable()
    {
        return $this->executable;
    }

    public function setExecutable($executable)
    {
        $this->executable = $executable;
    }

    public function getIsSubscribed()
    {
        return $this->isSubscribed;
    }

    public function setIsSubscribed($isSubscribed)
    {
        $this->isSubscribed = $isSubscribed;
    }

    public function getMyRights()
    {
        return $this->myRights;
    }

    public function setMyRights($myRights)
    {
        $this->myRights = $myRights;
    }

    public function getShareWith()
    {
        return $this->shareWith;
    }

    public function setShareWith($shareWith)
    {
        $this->shareWith = $shareWith;
    }

    /**
     * Build a FileNode from a JSON object (stdClass or associative array).
     * Used by FileNodeSetMethod when deserializing incoming request data.
     */
    public static function fromJson($data)
    {
        $data = is_array($data) ? (object) $data : $data;
        $node = new self(isset($data->id) ? $data->id : null);

        $fields = [
            'parentId', 'blobId', 'name', 'type', 'size',
            'created', 'modified', 'accessed', 'changed',
            'nodeType', 'role', 'executable', 'isSubscribed',
            'myRights', 'shareWith',
        ];

        foreach ($fields as $field) {
            if (isset($data->$field)) {
                $setter = 'set' . ucfirst($field);
                $node->$setter($data->$field);
            }
        }

        return $node;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "id"           => $this->id,
            "parentId"     => $this->parentId,
            "blobId"       => $this->blobId,
            "name"         => $this->name,
            "type"         => $this->type,
            "size"         => $this->size,
            "created"      => $this->created,
            "modified"     => $this->modified,
            "accessed"     => $this->accessed,
            "changed"      => $this->changed,
            "nodeType"     => $this->nodeType,
            "role"         => $this->role,
            "executable"   => $this->executable,
            "isSubscribed" => $this->isSubscribed,
            "myRights"     => $this->myRights,
            "shareWith"    => $this->shareWith,
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
        $this->name = AdapterUtil::reencode($this->name);
    }
}
