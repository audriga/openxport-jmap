<?php

namespace OpenXPort\Jmap\Task;

use JsonSerializable;

class Link implements JsonSerializable
{
    private $type;
    private $href;
    private $cid;
    private $contentType;
    private $size;
    private $rel;
    private $display;
    private $title;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function setHref($href)
    {
        $this->href = $href;
    }

    public function getCid()
    {
        return $this->cid;
    }

    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getRel()
    {
        return $this->rel;
    }

    public function setRel($rel)
    {
        $this->rel = $rel;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type" => $this->getType(),
            "href" => $this->getHref(),
            "cid" => $this->getCid(),
            "contentType" => $this->getContentType(),
            "size" => $this->getSize(),
            "rel" => $this->getRel(),
            "display" => $this->getDisplay(),
            "title" => $this->getTitle()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
