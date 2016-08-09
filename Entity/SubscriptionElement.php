<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PackElement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\SubscriptionElementRepository")
 *
 * @ORM\MappedSuperclass
 */
final class SubscriptionElement
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
     * @ORM\ManyToOne(targetEntity="ProductSubscription", inversedBy="subscriptionElements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productSubscription;

    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $shippingAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $shippedAt;



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
     * Set productSubscription
     *
     * @param ProductSubscription $product
     * @return SubscriptionElement
     */
    public function setProductSubscription(ProductSubscription $product)
    {
        $this->productSubscription = $product;

        return $this;
    }

    /**
     * Get productSubscription
     *
     * @return ProductSubscription
     */
    public function getProductSubscription()
    {
        return $this->productSubscription;
    }

    /**
     * @return \DateTime
     */
    public function getShippedAt() : \DateTime
    {
        return $this->shippedAt;
    }

    /**
     * @param $shippedAt
     * @return SubscriptionElement
     */
    public function setShippedAt($shippedAt) : SubscriptionElement
    {
        $this->shippedAt = $shippedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getShippingAt() : \DateTime
    {
        return $this->shippingAt;
    }

    /**
     * @param \DateTime $shippingAt
     * @return SubscriptionElement
     */
    public function setShippingAt(\DateTime $shippingAt) : SubscriptionElement
    {
        $this->shippingAt = $shippingAt;
        return $this;
    }
}
