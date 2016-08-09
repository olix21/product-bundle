<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PackElement
 *
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\PackElementRepository")
 * @ORM\MappedSuperclass
 *
 */
final class PackElement
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
     * @ORM\ManyToOne(targetEntity="ProductPack", inversedBy="packElements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productPack;

    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;



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
     * Set productPack
     *
     * @param ProductPack $product
     * @return PackElement
     */
    public function setProductPack(ProductPack $product)
    {
        $this->productPack = $product;

        return $this;
    }

    /**
     * Get productPack
     *
     * @return BaseProduct
     */
    public function getProductPack()
    {
        return $this->productPack;
    }
}
