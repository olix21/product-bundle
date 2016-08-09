<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Product
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\ProductSubscriptionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductSubscription extends BaseProduct
{

    /**
     * @var string
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $recurrence;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recurrenceUnit;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionElement", mappedBy="productSubscription", cascade={"persist", "remove"})
     */
    private $subscriptionElements;


    public function __construct()
    {
        parent::__construct();
        $this->subscriptionElements = new ArrayCollection();
    }

    /**
     * @deprecated use setRecurrenceUnit
     * Set recurrenceFreq
     * @param string $recurrenceFreq
     * @return Product
     */
    public function setRecurrenceFreq($recurrenceFreq){
        return $this->setRecurrenceUnit($recurrenceFreq);
    }

    /**
     * @deprecated use getRecurrenceUnit
     * Get recurrenceFreq
     * @return string
     */
    public function getRecurrenceFreq(){
        return $this->recurrenceUnit;
    }

    /**
     * Set recurrence
     * @param integer $recurrence
     * @return Product
     */
    public function setRecurrence($recurrence){
        $this->recurrence = $recurrence;
        return $this;
    }

    /**
     * Get recurrence
     * @return integer
     */
    public function getRecurrence(){
        return $this->recurrence;
    }

    /**
     * Set recurrenceUnit
     * @param string $recurrenceUnit
     * @return Product
     */
    public function setRecurrenceUnit($recurrenceUnit){
        $this->recurrenceUnit = $recurrenceUnit;
        return $this;
    }

    /**
     * Get recurrenceUnit
     * @return string
     */
    public function getRecurrenceUnit(){
        return $this->recurrenceUnit;
    }

    /**
     * Add packElements
     * @param \Dywee\ProductBundle\Entity\PackElement $packElements
     * @return ProductSubscription
     */
    public function addSubscriptionElement(PackElement $packElements)
    {
        $this->subscriptionElements[] = $packElements;
        $packElements->setParent($this);

        return $this;
    }

    /**
     * Remove packElements
     * @param \Dywee\ProductBundle\Entity\PackElement $packElements
     * @return ProductSubscription
     */
    public function removeSubscriptionElement(PackElement $packElements){
        $this->subscriptionElements->removeElement($packElements);
        $packElements->setParent(null);

        return $this;
    }

    /**
     * Get packElements
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubscriptionElements(){
        return $this->subscriptionElements;
    }

}
