<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineUserBundle\Entity\User as BaseUser;

/**
 * Application\YrchBundle\Entity\User
 *
 * @orm:Entity(repositoryClass="Bundle\DoctrineUserBundle\Entity\UserRepository")
 * @orm:Table(name="user")
 */
class User extends BaseUser
{
    /**
     *
     * @orm:Column(name="nick", type="string", length=255)
     * 
     * @var string 
     */
    protected $nick;

    public function  __construct()
    {
        parent::__construct();
        $this->nick='Meriadoc';
    }

    /**
     * Set nick
     *
     * @param string $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * Get nick
     *
     * @return string $nick
     */
    public function getNick()
    {
        return $this->nick;
    }
}