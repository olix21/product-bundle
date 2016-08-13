<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractPackElement
 *
 * @ORM\Entity
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "packElement" = "PackElement",
 *     "subscriptionElement" = "SubscriptionElement",
 * })
 *
 */
abstract class AbstractPackElement
{
    const STATE_WAITING = 'waiting';
    const STATE_PREPARED = 'prepared';
    const STATE_SHIPPING = 'shipping';
    const STATE_SHIPPED = 'shipped';
    const STATE_RETURNED = 'returned';
    const STATE_REFUND = 'refund';

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
    protected $quantity = 1;

    /**
     * @var float
     *
     * @ORM\Column(name="discountRate", type="float")
     */
    protected $discountRate = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="discountValue", type="decimal", precision=10, scale=2)
     */
    protected $discountValue = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="unitPrice", type="decimal", precision=10, scale=2)
     */
    protected $unitPrice = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="totalPrice", type="decimal", precision=10, scale=2)
     */
    protected $totalPrice = 0;

    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $product;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $state = self::STATE_WAITING;


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
     * @param BaseProduct $product
     * @return PackElement
     */
    public function setProduct(BaseProduct $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return BaseProduct
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
}
