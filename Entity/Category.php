<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Entity\CategoryRepository")
 */
class Category implements Translatable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enableMulti", type="boolean")
     */
    private $enableMulti = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $isVisible = true;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state = 1;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="smallint")
     */
    private $position = 0;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @ORM\OneToOne(targetEntity="Dywee\ProductBundle\Entity\ProductImage")
     * @ORM\JoinColumn(nullable=true)
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="Dywee\ProductBundle\Entity\Product", mappedBy="categories")
     */
    private $product;

    /**
     * @ORM\Column(name="seoUrl", type="string", length=255, nullable=true)
     */
    private $seoUrl;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set enableMulti
     *
     * @param boolean $enableMulti
     * @return Category
     */
    public function setEnableMulti($enableMulti)
    {
        $this->enableMulti = $enableMulti;

        return $this;
    }

    /**
     * Get enableMulti
     *
     * @return boolean 
     */
    public function getEnableMulti()
    {
        return $this->enableMulti;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Category
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set parentCategory
     *
     * @param \Dywee\ProductBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\Dywee\ProductBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parentCategory
     *
     * @return \Dywee\ProductBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Set images
     *
     * @param \Dywee\ProductBundle\Entity\Image $images
     * @return Category
     */
    public function setImages(\Dywee\ProductBundle\Entity\ProductImage $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Dywee\ProductBundle\Entity\Image 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add children
     *
     * @param \Dywee\ProductBundle\Entity\Category $children
     * @return Category
     */
    public function addChildCategory(\Dywee\ProductBundle\Entity\Category $child)
    {
        $this->children[] = $child;
        $child->setParent($this);

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Dywee\ProductBundle\Entity\Category $chil
     */
    public function removeChildCategory(\Dywee\ProductBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set visible
     *
     * @param boolean $isVisible
     * @return Category
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function sortChildCategories()
    {
        $sorted = array();
        $return = array();
        foreach($this->getChildren() as $child)
        {
            $sorted[$child->getPosition() > 0 ?$child->getPosition():$child->getName()] = $child;
        }


        ksort($sorted);

        foreach($sorted as $key => $value)
            $return[] = $value;

        return $return;

    }

    /**
     * Add product
     *
     * @param \Dywee\ProductBundle\Entity\Product $product
     *
     * @return Category
     */
    public function addProduct(\Dywee\ProductBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Dywee\ProductBundle\Entity\Product $product
     */
    public function removeProduct(\Dywee\ProductBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set seoUrl
     *
     * @param string $seoUrl
     *
     * @return Category
     */
    public function setSeoUrl($seoUrl)
    {
        $this->seoUrl = $seoUrl;

        return $this;
    }

    /**
     * Get seoUrl
     *
     * @return string
     */
    public function getSeoUrl()
    {
        return $this->seoUrl;
    }

    public function getUrl()
    {
        if($this->getSeoUrl() != '')
            return $this->getSeoUrl();
        else return $this->getId();
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return Category
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return Category
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return Category
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     *
     * @return Category
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Add child
     *
     * @param \Dywee\ProductBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\Dywee\ProductBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Dywee\ProductBundle\Entity\Category $child
     */
    public function removeChild(\Dywee\ProductBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    public function getIndentedName() {
        if($this->lvl > 0)
            return str_repeat($this->parent->name." > ", $this->lvl) . $this->name;
        else return $this->name;
    }
}
