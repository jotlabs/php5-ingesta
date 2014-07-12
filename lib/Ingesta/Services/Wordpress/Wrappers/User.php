<?php
namespace Ingesta\Services\Wordpress\Wrappers;

class User
{
    protected $user;


    public function __construct($user)
    {
        $this->user = (object) $user;
    }


    public function data()
    {
        return array(
            'username'   => $this->getUserName(),
            'slug'       => $this->getSlug(),
            'firstName'  => $this->getFirstName(),
            'lastName'   => $this->getLastName(),
            'registered' => $this->getRegisteredDate(),
            'bio'        => $this->getBio(),
            'roles'      => $this->user->roles
        );
    }


    public function getId()
    {
        return $this->user->user_id;
    }


    public function getUserName()
    {
        return $this->user->username;
    }


    public function getSlug()
    {
        return $this->user->nicename;
    }


    public function getFirstName()
    {
        return $this->user->first_name;
    }


    public function getLastName()
    {
        return $this->user->last_name;
    }


    public function getRegisteredDate()
    {
        return $this->user->registered;
    }


    public function getBio()
    {
        return $this->user->bio;
    }


    public function isAdministrator()
    {
        return in_array('administrator', $this->user->roles);
    }
}
