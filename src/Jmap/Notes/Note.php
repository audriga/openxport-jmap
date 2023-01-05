<?php

namespace OpenXPort\Jmap\Note;

use JsonSerializable;

class Note implements JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $notebookId;

    /** @var string */
    private $created;

    /** @var string */
    private $updated;

    /** @var string */
    private $name;

    /** @var string */
    private $body;

    /** @var string */
    private $bodyContentType;

    /** @var array */
    private $keywords;

    /** @var array */
    private $categories;

    /** @var string */
    private $color;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNotebookId()
    {
        return $this->notebookId;
    }

    public function setNotebookId($notebookId)
    {
        $this->notebookId = $notebookId;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBodyContentType()
    {
        return $this->bodyContentType;
    }

    public function setBodyContentType($bodyContentType)
    {
        $this->bodyContentType = $bodyContentType;
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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "notebookId" => $this->getNotebookId(),
            "created" => $this->getCreated(),
            "updated" => $this->getUpdated(),
            "name" => $this->getName(),
            "body" => $this->getBody(),
            "bodyContentType" => $this->getBodyContentType(),
            "keywords" => $this->getKeywords(),
            "categories" => $this->getCategories(),
            "color" => $this->getColor()
        ];
    }
}
