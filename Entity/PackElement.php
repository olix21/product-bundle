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
final class PackElement extends AbstractPackElement
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductPack", inversedBy="packElements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productPack;


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
