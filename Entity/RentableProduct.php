<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RentableProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RentableProduct extends BaseProduct
{
    /**
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\RentableProductItem", mappedBy="parent")
     */
    private $items;


    public function __construct()
    {
        $this->items = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @param RentableProductItem $item
     * @return RentableProduct
     */
    public function addItem(RentableProductItem $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param RentableProductItem $item
     * @return RentableProduct
     */
    public function removeItem(RentableProductItem $item)
    {
        $this->items->removeElement($item);
        return $this;
    }
}
