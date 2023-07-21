<?php

namespace App\Models;

class EventsModel extends Model
{
    protected $title;
    protected $content;
    protected $owner;
    protected $assocId;


    public function __construct()
    {
        $this->table = "events";
    }

    public function findAllByAssocId($id)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE assocId = ?", [$id])->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssocId()
    {
        return $this->assocId;
    }

    /**
     * @param mixed $assocId
     */
    public function setAssocId($assocId): self
    {
        $this->assocId = $assocId;
        return $this;
    }
}