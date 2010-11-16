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
     * @validation:NotBlank(message="Please enter your nick")
     * @orm:Column(name="nick", type="string", length=255)
     */
    protected $nick;

    /**
     * @var boolean
     *
     * @validation:AssertType(type="boolean")
     * @orm:Column(name="is_locked", type="boolean")
     */
    protected $isLocked;

    /**
     * @var string
     *
     * @orm:Column(name="prefered_locale", type="string", length=10)
     */
    protected $preferedLocale;

    /**
     * @var string
     *
     * @validation:NotBlank()
     * @orm:Column(name="theme", type="string", length=255)
     */
    protected $theme;

    /**
     * @var string
     *
     * @validation:NotBlank()
     * @orm:Column(name="outlink", type="string", length=255)
     */
    protected $outlink;

    /**
     * @var boolean
     *
     * @validation:AssertType(type="boolean")
     * @orm:Column(name="contact_allowed", type="boolean")
     */
    protected $contactAllowed;

    /**
     * @var integer
     *
     * @orm:Column(name="sites_per_page", type="integer")
     */
    protected $sitesPerPage;

    /**
     * @var integer
     *
     * @orm:Column(name="reviews_per_page", type="integer")
     */
    protected $reviewsPerPage;

    /**
     * @var boolean
     *
     * @validation:AssertType(type="boolean")
     * @orm:Column(name="site_notifications", type="boolean")
     */
    protected $siteNotifications;

    /**
     * @var boolean
     *
     * @validation:AssertType(type="boolean")
     * @orm:Column(name="review_notifications", type="boolean")
     */
    protected $reviewNotifications;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @orm:ManyToMany(targetEntity="Application\YrchBundle\Entity\Site", mappedBy="owners")
     */
    protected $sites;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @orm:OneToMany(targetEntity="Application\YrchBundle\Entity\Review", mappedBy="owner")
     */
    protected $reviews;

    public function  __construct()
    {
        parent::__construct();
        $this->sites = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->nick = 'Meriadoc'; // Remove this line when the form will pass the value
        $this->isLocked = false;
        $this->theme = 'default';
        $this->contactAllowed = true;
        $this->outlink = '_blank';
        $this->sitesPerPage = 10;
        $this->reviewsPerPage = 25;
        $this->siteNotifications = true;
        $this->reviewNotifications = true;
    }

    /**
     * @codeCoverageIgnore
     */
    public function  __toString()
    {
        return (string) $this->getNick();
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
        $this->isLocked = true;
    }

    /**
     * Unlock the user
     */
    public function unlock()
    {
        $this->isLocked = false;
    }

    /**
     * implements AdvancedAccountInterface
     * @return boolean true if the account is NOT locked
     */
    public function isAccountNonLocked()
    {
        return !$this->isLocked;
    }

    /**
     * Set the prefered locale
     *
     * @param string $locale
     */
    public function setPreferedLocale($locale)
    {
        $this->preferedLocale = $locale;
    }

    /**
     * Get prefered locale
     *
     * @return string
     */
    public function getPreferedLocale()
    {
        return $this->preferedLocale;
    }

    /**
     * Set the theme used by this user
     *
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get the theme used by this user
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set the outlink
     *
     * @param string $outlink
     */
    public function setOutlink($outlink)
    {
        $this->outlink = $outlink;
    }

    /**
     * Get the outlink
     *
     * @return string
     */
    public function getOutlink()
    {
        return $this->outlink;
    }

    /**
     * Set the contact autorisation
     *
     * @param boolean $allowed
     */
    public function setContactAllowed($allowed)
    {
        $this->contactAllowed = $allowed;
    }

    /**
     * Whether other user can send email to this user
     *
     * @return boolean
     */
    public function isContactAllowed()
    {
        return $this->contactAllowed;
    }

    /**
     * Set the number of sites displayed per page
     *
     * @param integer $sites_per_page
     */
    public function setSitesPerPage($sites_per_page)
    {
        $this->sitesPerPage = $sites_per_page;
    }

    /**
     * Get the number of sites displayed per page
     *
     * @return integer
     */
    public function getSitesPerPage(){
        return $this->sitesPerPage;
    }

    /**
     * Set the number of reviews displayed per page
     *
     * @param integer $reviews_per_page
     */
    public function setReviewsPerPage($reviews_per_page)
    {
        $this->reviewsPerPage = $reviews_per_page;
    }

    /**
     * Get the number of reviews displayed per page
     *
     * @return integer
     */
    public function getReviewsPerPage()
    {
        return $this->reviewsPerPage;
    }

    /**
     * Set the notification behavior for sites
     *
     * @param boolean $notify
     */
    public function setSiteNotifications($notify)
    {
        $this->siteNotifications = $notify;
    }

    /**
     * Get the notification behavior for sites
     *
     * @return boolean
     */
    public function getSiteNotifications()
    {
        return $this->siteNotifications;
    }

    /**
     * Set the notification behavior for reviews
     *
     * @param boolean $notify
     */
    public function setReviewNotifications($notify)
    {
        $this->reviewNotifications = $notify;
    }

    /**
     * Get the notification behavior for reviews
     *
     * @return boolean
     */
    public function getReviewNotifications()
    {
        return $this->reviewNotifications;
    }

    /**
     * Add site
     *
     * @param Site $site
     */
    public function addSite(Site $site)
    {
        if (!$this->getSites()->contains($site)){
            $this->getSites()->add($site);
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

    /**
     * Add a review
     *
     * @param Review $review
     */
    public function addReview(Review $review)
    {
        if (!$this->getReviews()->contains($review)){
            $review->setOwner($this);
            $this->getReviews()->add($review);
        }
    }

    /**
     * Get reviews
     *
     * @return Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }
}
