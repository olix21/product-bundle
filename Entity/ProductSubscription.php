<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\ProductSubscriptionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductSubscription  extends BaseProduct
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

}
