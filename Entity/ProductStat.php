<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductStat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\ProductStatRepository")
 */
class ProductStat
{

    const TYPE_DISPLAY = 'display';
    const TYPE_ADD_TO_BASKET = 'add_to_basket';
    const TYPE_BUY = 'buy';
    const TYPE_RETURNED = 'returned';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct", inversedBy="productStats")
     */
    private $product;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;


    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $trackingKey;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private $attempts = 1;



    /**
     * ProductStat constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

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
     * Set type
     *
     * @param integer $type
     * @return ProductStat
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return ProductStat
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
     * Set product
     *
     * @param BaseProduct $product
     * @return ProductStat
     */
    public function setProduct(BaseProduct $product = null)
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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getTrackingKey()
    {
        return $this->trackingKey;
    }

    /**
     * @param mixed $trackingKey
     */
    public function setTrackingKey($trackingKey)
    {
        $this->trackingKey = $trackingKey;
    }

    /**
     * @return int
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     * @return ProductStat
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;
        return $this;
    }


}
