<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Product
 *
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product extends BaseProduct
{

}
