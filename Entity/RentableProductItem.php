<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RentableProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RentableProductItem extends BaseProduct
{
    /**
     * @ORM\ManyToOne(targetEntity="RentableProduct", inversedBy="items")
     */
    private $parent;


    /**
     * Set parent
     *
     * @param RentableProduct $parent
     * @return RentableProduct extends BaseProduct
     */
    public function setParent(RentableProduct $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return RentableProduct
     */
    public function getParent()
    {
        return $this->parent;
    }
}
