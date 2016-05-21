<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PackElement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\PackElementRepository")
 */
class PackElement
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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity = 1;

    /**
     * @var float
     *
     * @ORM\Column(name="discountRate", type="float")
     */
    private $discountRate = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="discountValue", type="float")
     */
    private $discountValue = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="unitPrice", type="float")
     */
    private $unitPrice = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="totalPrice", type="float")
     */
    private $totalPrice = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\BaseProduct", inversedBy="packElements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;


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
     * Set quantity
     *
     * @param integer $quantity
     * @return PackElement
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set discountRate
     *
     * @param float $discountRate
     * @return PackElement
     */
    public function setDiscountRate($discountRate)
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    /**
     * Get discountRate
     *
     * @return float 
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    /**
     * Set discountValue
     *
     * @param float $discountValue
     * @return PackElement
     */
    public function setDiscountValue($discountValue)
    {
        $this->discountValue = $discountValue;

        return $this;
    }

    /**
     * Get discountValue
     *
     * @return float 
     */
    public function getDiscountValue()
    {
        return $this->discountValue;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     * @return PackElement
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float 
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     * @return PackElement
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float 
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set product
     *
     * @param \Dywee\ProductBundle\Entity\Product $product
     * @return PackElement
     */
    public function setProduct(\Dywee\ProductBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Dywee\ProductBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
