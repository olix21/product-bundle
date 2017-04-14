<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductVariant
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ProductVariant
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
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPriceTTC", type="boolean", nullable=true)
     */
    private $isPriceTTC = true;

    /**
     * @var string
     *
     * @ORM\Column(name="recurrenceFreq", type="string", length=255, nullable=true)
     */
    private $recurrenceFreq;

    /**
     * @var string
     *
     * @ORM\Column(name="recurrence", type="smallint", nullable=true)
     */
    private $recurrence;

    /**
     * @var string
     *
     * @ORM\Column(name="length", type="decimal", scale=3, nullable=true)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="decimal", scale=3, nullable=true)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="decimal", scale=3, nullable=true)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="decimal", scale=3, nullable=true)
     */
    private $weight = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPromotion", type="boolean")
     */
    private $isPromotion = false;

    /**
     * @var string
     *
     * @ORM\Column(name="promotionPrice", type="decimal", scale=3, nullable=true)
     */
    private $promotionPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state = 1;

    /**
     * @ORM\Column(name="availableAt", type="date", nullable=true)
     */
    private $availableAt;

    /**
     * @ORM\Column(name="mainVariation", type="boolean")
     */
    private $mainVariation = true;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\CoreBundle\Model\ProductInterface", inversedBy="productVariants")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="Dywee\ProductBundle\Entity\ProductOptionValue")
     */
    private $productOptionValues;

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
     * Set price
     *
     * @param string $price
     *
     * @return ProductVariant
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isPriceTTC
     *
     * @param boolean $isPriceTTC
     *
     * @return ProductVariant
     */
    public function setIsPriceTTC($isPriceTTC)
    {
        $this->isPriceTTC = $isPriceTTC;

        return $this;
    }

    /**
     * Get isPriceTTC
     *
     * @return boolean
     */
    public function getIsPriceTTC()
    {
        return $this->isPriceTTC;
    }

    /**
     * Set recurrenceFreq
     *
     * @param string $recurrenceFreq
     *
     * @return ProductVariant
     */
    public function setRecurrenceFreq($recurrenceFreq)
    {
        $this->recurrenceFreq = $recurrenceFreq;

        return $this;
    }

    /**
     * Get recurrenceFreq
     *
     * @return string
     */
    public function getRecurrenceFreq()
    {
        return $this->recurrenceFreq;
    }

    /**
     * Set recurrence
     *
     * @param integer $recurrence
     *
     * @return ProductVariant
     */
    public function setRecurrence($recurrence)
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * Get recurrence
     *
     * @return integer
     */
    public function getRecurrence()
    {
        return $this->recurrence;
    }

    /**
     * Set length
     *
     * @param string $length
     *
     * @return ProductVariant
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set width
     *
     * @param string $width
     *
     * @return ProductVariant
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     *
     * @return ProductVariant
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set weight
     *
     * @param string $weight
     *
     * @return ProductVariant
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return ProductVariant
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set isPromotion
     *
     * @param boolean $isPromotion
     *
     * @return ProductVariant
     */
    public function setIsPromotion($isPromotion)
    {
        $this->isPromotion = $isPromotion;

        return $this;
    }

    /**
     * Get isPromotion
     *
     * @return boolean
     */
    public function getIsPromotion()
    {
        return $this->isPromotion;
    }

    /**
     * Set promotionPrice
     *
     * @param string $promotionPrice
     *
     * @return ProductVariant
     */
    public function setPromotionPrice($promotionPrice)
    {
        $this->promotionPrice = $promotionPrice;

        return $this;
    }

    /**
     * Get promotionPrice
     *
     * @return string
     */
    public function getPromotionPrice()
    {
        return $this->promotionPrice;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return ProductVariant
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
     * Set availableAt
     *
     * @param \DateTime $availableAt
     *
     * @return ProductVariant
     */
    public function setAvailableAt($availableAt)
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    /**
     * Get availableAt
     *
     * @return \DateTime
     */
    public function getAvailableAt()
    {
        return $this->availableAt;
    }

    /**
     * Set mainVariation
     *
     * @param boolean $mainVariation
     *
     * @return ProductVariant
     */
    public function setMainVariation($mainVariation)
    {
        $this->mainVariation = $mainVariation;

        return $this;
    }

    /**
     * Get mainVariation
     *
     * @return boolean
     */
    public function getMainVariation()
    {
        return $this->mainVariation;
    }

    /**
     * Set product
     *
     * @param \Dywee\ProductBundle\Entity\Product $product
     *
     * @return ProductVariant
     */
    public function setProduct(\Dywee\ProductBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Dywee\ProductBundle\Entity\ProductVariant
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productOptionValues = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productOptionValue
     *
     * @param \Dywee\ProductBundle\Entity\ProductOptionValue $productOptionValue
     *
     * @return ProductVariant
     */
    public function addProductOptionValue(\Dywee\ProductBundle\Entity\ProductOptionValue $productOptionValue)
    {
        $this->productOptionValues[] = $productOptionValue;

        return $this;
    }

    /**
     * Remove productOptionValue
     *
     * @param \Dywee\ProductBundle\Entity\ProductOptionValue $productOptionValue
     */
    public function removeProductOptionValue(\Dywee\ProductBundle\Entity\ProductOptionValue $productOptionValue)
    {
        $this->productOptionValues->removeElement($productOptionValue);
    }

    /**
     * Get productOptionValue
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductOptionValues()
    {
        return $this->productOptionValues;
    }
}
