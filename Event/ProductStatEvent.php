<?php

namespace Dywee\ProductBundle\Event;

use Dywee\ProductBundle\Entity\BaseProduct;
use Symfony\Component\EventDispatcher\Event;

class ProductStatEvent extends Event
{
    private $product;

    public function __construct(BaseProduct $product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }
}