<?php

namespace Yrch\YrchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Yrch\YrchBundle\Entity\AbstractSite
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractSite
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $url
     *
     * @Assert\NotBlank(message="Please enter the url")
     * @Assert\Url(message="This is not a valid url")
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    protected $url;

    /**
     * @var string $title
     *
     * @Assert\NotBlank(message="Please enter the name")
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string $locale
     *
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     * @Gedmo\Translatable
     */
    protected $description;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="languages", type="string", length=255)
     */
    protected $stored_languages;

    /**
     * @var array
     */
    protected $languages = array ();

    /**
     * @var string
     *
     * @ORM\Column(name="countries", type="string", length=255)
     */
    protected $stored_countries;

    /**
     * @var array
     */
    protected $countries = array ();

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $categories
     *
     * @ORM\ManyToMany(targetEntity="Yrch\YrchBundle\Entity\Category")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="site_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $categories;

    public function  __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set languages
     *
     * @param array $languages
     */
    public function setLanguages(array $languages)
    {
        $this->languages = $languages;
    }

    /**
     * Get languages
     *
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set coutries
     *
     * @param array $countries
     */
    public function setCountries(array $countries)
    {
        $this->countries = $countries;
    }

    /**
     * Get countries
     *
     * @return array
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * Add category
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        if (!$this->getCategories()->contains($category)){
            $this->getCategories()->add($category);
        }
    }

    /**
     * Remove category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->getCategories()->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Set the creation date.
     *
     * This is only used when you remove the TranslationListener to force the
     * creation date. In other case I will be overwritten by the Translatable
     * behavior.
     *
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->createdAt = $created_at;
    }

    /**
     * Set the update date.
     *
     * This is only used when you remove the TranslationListener to force the
     * creation date. In other case I will be overwritten by the Translatable
     * behavior.
     *
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt(\DateTime $updated_at)
    {
        $this->updatedAt = $updated_at;
    }

    /**
     * @ORM\PostLoad
     */
    public function populateArrays()
    {
        $this->languages = explode('|', $this->stored_languages);
        $this->countries = explode('|', $this->stored_countries);
    }

    /**
     * @ORM\PrePersist
     */
    public function populateStrings()
    {
        $this->stored_languages = implode('|', $this->languages);
        $this->stored_countries = implode('|', $this->countries);
    }
}
