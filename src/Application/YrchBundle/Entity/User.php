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
     * @var string
     *
     * @orm:Column(name="nick", type="string", length=255)
     */
    protected $nick;

    /**
     * @var boolean
     *
     * @orm:Column(name="is_locked", type="boolean")
     */
    protected $is_locked;

    /**
     * @orm:ManyToMany(targetEntity="Application\YrchBundle\Entity\Site", mappedBy="owner")
     */
    private $sites;

    public function  __construct()
    {
        parent::__construct();
        $this->sites = new ArrayCollection();
        $this->nick = 'Meriadoc'; // Remove this line when the form will pass the value
        $this->is_locked = false;
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
     * Lock the user
     */
    public function lock()
    {
        $this->is_locked = true;
    }

    /**
     * Unlock the user
     */
    public function unlock()
    {
        $this->is_locked = false;
    }

    /**
     * implements AdvancedAccountInterface
     * @return boolean true if the account is NOT locked
     */
    public function isAccountNonLocked()
    {
        return !$this->is_locked;
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
