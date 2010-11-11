<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineUserBundle\Entity\User as BaseUser;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * @orm:ManyToMany(targetEntity="Application\YrchBundle\Entity\Site", mappedBy="owner")
     */
    private $sites;

    public function  __construct()
    {
        parent::__construct();
        $this->sites = new ArrayCollection();
        $this->nick = 'Meriadoc';
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

    /**
     * Add site
     *
     * @param Site $site
     */
    public function addSite(Site $site)
    {
        if (!$this->sites->contains($site)){
            $this->sites[] = $site;
        }
    }

    /**
     * Get sites
     *
     * @return Collection $sites
     */
    public function getSites()
    {
        return $this->sites;
    }
}