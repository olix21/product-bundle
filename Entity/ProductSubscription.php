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
    const RECURRENCE_UNIT_DAY = 'day';
    const RECURRENCE_UNIT_WEEK = 'week';
    const RECURRENCE_UNIT_MONTH = 'month';
    const RECURRENCE_UNIT_YEAR = 'year';
    
    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $maxShipment;

    /**
     * @var string
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $recurrence;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recurrenceUnit = self::RECURRENCE_UNIT_MONTH;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionElement", mappedBy="productSubscription", cascade={"persist", "remove"})
     */
    private $subscriptionElements;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $priceByShipment = false;


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

    /**
     * @return int
     */
    public function getMaxShipment()
    {
        return $this->maxShipment;
    }

    /**
     * @param int $maxShipment
     * @return ProductSubscription
     */
    public function setMaxShipment($maxShipment)
    {
        $this->maxShipment = $maxShipment;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPriceByShipment()
    {
        return $this->priceByShipment;
    }

    /**
     * @param boolean $priceByShipment
     * @return ProductSubscription
     */
    public function setPriceByShipment($priceByShipment)
    {
        $this->priceByShipment = $priceByShipment;
        return $this;
    }


}
