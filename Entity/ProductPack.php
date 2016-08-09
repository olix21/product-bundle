<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\ProductPackRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductPack  extends BaseProduct
{

    /**
     * @ORM\OneToMany(targetEntity="PackElement", mappedBy="productPack", cascade={"persist", "remove"})
     */
    private $packElements;


    public function __construct()
    {
        parent::__construct();
        $this->packElements = new ArrayCollection();
    }


    /**
     * Add packElements
     * @param \Dywee\ProductBundle\Entity\PackElement $packElements
     * @return ProductPack
     */
    public function addPackElement(PackElement $packElements)
    {
        $this->packElements[] = $packElements;
        $packElements->setParent($this);

        return $this;
    }

    /**
     * Remove packElements
     * @param \Dywee\ProductBundle\Entity\PackElement $packElements
     * @return ProductPack
     */
    public function removePackElement(PackElement $packElements){
        $this->packElements->removeElement($packElements);
        $packElements->setParent(null);

        return $this;
    }

    /**
     * Get packElements
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackElements(){
        return $this->packElements;
    }
}
