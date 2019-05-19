<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOptionValue
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProductOptionValue
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\ProductOption", inversedBy="productOptionValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productOption;


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
     * Set name
     *
     * @param string $name
     *
     * @return ProductOptionValue
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set productOption
     *
     * @param \Dywee\ProductBundle\Entity\ProductOption $productOption
     *
     * @return ProductOptionValue
     */
    public function setProductOption(\Dywee\ProductBundle\Entity\ProductOption $productOption)
    {
        $this->productOption = $productOption;

        return $this;
    }

    /**
     * Get productOption
     *
     * @return \Dywee\ProductBundle\Entity\ProductOption
     */
    public function getProductOption()
    {
        return $this->productOption;
    }

    public function getIndentedName()
    {
        return $this->getProductOption()->getName() . " > " . $this->name;
    }
}
