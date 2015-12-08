<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="product_images")
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\ProductImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ProductImage
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
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255)
     */
    private $src;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\Product", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;


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
     * Set src
     *
     * @param string $src
     * @return Image
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string 
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set product
     *
     * @param \Dywee\ProductBundle\Entity\Product $product
     * @return Image
     */
    public function setProduct(\Dywee\ProductBundle\Entity\Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get product
     *
     * @return \Dywee\ProductBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
