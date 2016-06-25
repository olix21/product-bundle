<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeatureElement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\FeatureElementRepository")
 */
class FeatureElement
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
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\Product", inversedBy="features")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\Feature")
     */
    private $feature;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\FeatureValue")
     */
    private $value;

    /**
     * @ORM\Column(name="customValue", type="string", length=255, nullable=true)
     */
    private $customValue;

    /**
     * @ORM\Column(name="isCustomValue", type="boolean")
     */
    private $isCustomValue = false;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position = 1;


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
     * Set customValue
     *
     * @param string $customValue
     * @return FeatureElement
     */
    public function setCustomValue($customValue)
    {
        $this->customValue = $customValue;

        return $this;
    }

    /**
     * Get customValue
     *
     * @return string 
     */
    public function getCustomValue()
    {
        return $this->customValue;
    }

    /**
     * Set isCustomValue
     *
     * @param boolean $isCustomValue
     * @return FeatureElement
     */
    public function setIsCustomValue($isCustomValue)
    {
        $this->isCustomValue = $isCustomValue;

        return $this;
    }

    /**
     * Get isCustomValue
     *
     * @return boolean 
     */
    public function getIsCustomValue()
    {
        return $this->isCustomValue;
    }

    /**
     * Set feature
     *
     * @param \Dywee\ProductBundle\Entity\Feature $feature
     * @return FeatureElement
     */
    public function setFeature(\Dywee\ProductBundle\Entity\Feature $feature = null)
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get feature
     *
     * @return \Dywee\ProductBundle\Entity\Feature 
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Set value
     *
     * @param \Dywee\ProductBundle\Entity\FeatureValue $value
     * @return FeatureElement
     */
    public function setValue(\Dywee\ProductBundle\Entity\FeatureValue $value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return \Dywee\productBundle\Entity\FeatureValue 
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Set product
     *
     * @param \Dywee\ProductBundle\Entity\Product $product
     *
     * @return FeatureElement
     */
    public function setProduct(\Dywee\ProductBundle\Entity\Product $product = null)
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

    /**
     * Set position
     *
     * @param string $position
     * @return Feature
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get values
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }
}
