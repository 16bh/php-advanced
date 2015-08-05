<?php

class Page
{
    protected $id = null;
    protected $creatorId = null;
    protected $title = null;
    protected $content = null;
    protected $dateAdded = null;
    protected $dateUpdate = null;

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return null
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @return null
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    public function getIntro($count = 200)
    {
        return substr(strip_tags($this->content), 0, $count) . '...';
    }
}