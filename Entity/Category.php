<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dywee\CoreBundle\Model\Tree;
use Dywee\CoreBundle\Model\TreeInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category
 *
 * @ORM\Table()
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\CategoryRepository")
 * @Vich\Uploadable
 */
class Category implements Translatable, CategoryInterface, TreeInterface
{
    use Tree;

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
     * @ORM\Column(type="boolean")
     */
    private $enableMulti = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $enabled = true;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;


    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="smallint")
     */
    private $position = 0;

    /**
     * @ORM\ManyToMany(targetEntity="BaseProduct", mappedBy="categories")
     */
    private $product;

    /**
     * @ORM\Column(name="seoUrl", type="string", length=255, nullable=true)
     */
    private $seoUrl;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setEnableMulti($enableMulti)
    {
        $this->enableMulti = $enableMulti;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getEnableMulti()
    {
        return $this->enableMulti;
    }

    /**
     * @inheritdoc
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPosition()
    {
        return $this->position;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function addChildCategory(Category $child)
    {
        $this->children[] = $child;
        $child->setParent($this);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeChildCategory(Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * @inheritdoc
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @inheritdoc
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @inheritdoc
     */
    public function sortChildCategories()
    {
        $sorted = array();
        $return = array();
        foreach ($this->getChildren() as $child) {
            $sorted[$child->getPosition() > 0 ? $child->getPosition() : $child->getName()] = $child;
        }


        ksort($sorted);

        foreach ($sorted as $key => $value) {
            $return[] = $value;
        }

        return $return;
    }

    /**
     * @inheritdoc
     */
    public function addProduct(BaseProduct $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeProduct(BaseProduct $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * @inheritdoc
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @inheritdoc
     */
    public function setSeoUrl($seoUrl)
    {
        $this->seoUrl = $seoUrl;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSeoUrl()
    {
        return $this->seoUrl;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        if ($this->getSeoUrl() != '') {
            return $this->getSeoUrl();
        } else {
            return $this->getId();
        }
    }

    /**
     * @inheritdoc
     */
    public function addChild(Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeChild(Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * @inheritdoc
     */
    public function getIndentedName()
    {
        if ($this->lvl > 0) {
            return str_repeat($this->parent->name . " > ", $this->lvl) . $this->name;
        } else {
            return $this->name;
        }
    }
}
