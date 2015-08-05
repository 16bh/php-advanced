<?php

class User
{
    protected $id = null;
    protected $userType = null;
    protected $username = null;
    protected $email = null;
    protected $pass = null;
    protected $dateAdded = null;

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    public function isAdmin()
    {
        return ($this->userType == 'admin');
    }

    public function canEditPage(Page $p)
    {
        return ($this->isAdmin() || ($this->id == $p->getCreatorId()));
    }

    public function canCreatePage()
    {
        return ($this->isAdmin() || ($this->userType == 'author'));
    }
}