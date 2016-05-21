<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dywee\ProductBundle\Entity\Product;

/**
 * RentableProduct
 *
 * @ORM\Table(name="rentable_products")
 * @ORM\Entity
 */
class RentableProduct
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
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\Product", inversedBy="rentableProducts")
     */
    private $parent;

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
     * Set parent
     *
     * @param \Dywee\ProductBundle\Entity\Product $parent
     * @return RentableProduct
     */
    public function setParent(\Dywee\ProductBundle\Entity\Product $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Dywee\ProductBundle\Entity\Product 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
