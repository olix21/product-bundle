<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dywee\TagBundle\Entity\Tag;
use Dywee\UserBundle\Entity\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Tag
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ProductTag extends Tag
{
    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct", inversedBy="tags")
     */
    private $product;

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     * @return ProductTag
     */
    public function setProduct($product)
    {
        $this->product = $product;
        $this->setType('product');
        return $this;
    }


}
