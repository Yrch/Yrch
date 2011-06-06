<?php

namespace Yrch\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Yrch\YrchBundle\Entity\Site
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="Yrch\YrchBundle\Repository\SiteRepository")
 * @Gedmo\TranslationEntity(class="Yrch\YrchBundle\Entity\SiteTranslation")
 */
class Site extends AbstractSite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="average_score", type="decimal", precision=3, scale=1, nullable="true")
     */
    protected $averageScore;

    /**
     * @var string $selection
     *
     * @Assert\Type(type="boolean")
     * @ORM\Column(name="selection", type="boolean")
     */
    protected $selection;

    /**
     * @var string $leech
     *
     * @Assert\Type(type="boolean")
     * @ORM\Column(name="leech", type="boolean")
     */
    protected $leech;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=100)
     */
    protected $status;

    /**
     * @var string $notes
     *
     * @ORM\Column(name="notes", type="text")
     */
    protected $notes;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Yrch\YrchBundle\Entity\Review", mappedBy="site")
     */
    protected $reviews;

    /**
     * @var Yrch\YrchBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Yrch\YrchBundle\Entity\User")
     * @ORM\JoinColumn(name="super_owner_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $superOwner;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $owners
     *
     * @ORM\ManyToMany(targetEntity="Yrch\YrchBundle\Entity\User", inversedBy="sites")
     * @ORM\JoinTable(name="user_site",
     *      joinColumns={@ORM\JoinColumn(name="site_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    protected $owners;

    /**
     * @var Yrch\YrchBundle\Entity\SiteTemp $siteTemp
     *
     * @ORM\OneToOne(targetEntity="Yrch\YrchBundle\Entity\SiteTemp")
     * @ORM\JoinColumn(name="site_temp_id", referencedColumnName="id")
     */
    protected $siteTemp;

    public function  __construct()
    {
        parent::__construct();
        $this->status = 'pending';
        $this->leech = false;
        $this->selection = false;
        $this->notes = '';
        $this->reviews = new ArrayCollection();
        $this->owners = new ArrayCollection();
    }

    /**
     * Get the average score
     *
     * @return double
     */
    public function getAverageScore()
    {
        return $this->averageScore;
    }

    /**
     * Set the average score
     *
     * @param double|null $averageScore
     */
    public function setAverageScore($averageScore)
    {
        $this->averageScore = $averageScore;
    }

    /**
     * Add to selection
     */
    public function addToSelection()
    {
        $this->selection = true;
    }

    /**
     * Remove from selection
     *
     * @param boolean $selection
     */
    public function removeFromSelection()
    {
        $this->selection = false;
    }

    /**
     * Is in selection ?
     *
     * @return boolean
     */
    public function isSelectioned()
    {
        return $this->selection;
    }

    /**
     * Set leech
     *
     * @param boolean $leech
     */
    public function setLeech($leech)
    {
        $this->leech = $leech;
    }

    /**
     * is leech ?
     *
     * @return boolean
     */
    public function isLeech()
    {
        return $this->leech;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set notes
     *
     * @param text $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return text $notes
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add a review
     *
     * @param Review $review
     */
    public function addReview(Review $review)
    {
        if (!$this->getReviews()->contains($review)){
            $review->setSite($this);
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

    /**
     * Set Super Owner
     *
     * @param User $user
     */
    public function setSuperOwner(User $user)
    {
        $this->superOwner = $user;
        $this->addOwner($user);
    }

    /**
     * Get Super Owner
     *
     * @return User
     */
    public function getSuperOwner()
    {
        return $this->superOwner;
    }

    /**
     * Add an owner
     *
     * @param User $user
     */
    public function addOwner(User $user)
    {
        if (!$this->getOwners()->contains($user)){
            $user->addSite($this);
            $this->getOwners()->add($user);
        }
    }

    /**
     * Delete an owner
     *
     * @param User $user
     */
    public function removeOwner(User $user)
    {
        if ($this->isOwner($user)){
            if ($this->getSuperOwner() == $user){
                throw new \InvalidArgumentException('You cannot remove the super owner from the owners list');
            }
            if ($this->getOwners()->count() == 1){
                throw new \InvalidArgumentException('A site must have at least one owner');
            }
            $this->getOwners()->removeElement($user);
        }
    }

    /**
     * Get owners
     *
     * @return ArrayCollection $owners
     */
    public function getOwners()
    {
        return $this->owners;
    }

    /**
     * Return true if the given user is an owner
     *
     * @param User $user
     * @return boolean
     */
    public function isOwner(User $user)
    {
        return $this->getOwners()->contains($user);
    }

    /**
     * Set temporary site
     *
     * @param SiteTemp site_temp
     */
    public function setSiteTemp(SiteTemp $site_temp)
    {
        $this->siteTemp = $site_temp;
    }

    /**
     * Get temporary site
     *
     * @return SiteTemp
     */
    public function getSiteTemp()
    {
        return $this->siteTemp;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
