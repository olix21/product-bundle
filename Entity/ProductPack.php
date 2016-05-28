<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

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
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\PackElement", mappedBy="product", cascade={"persist", "remove"})
     */
    private $packElements;


    /**
     * Add packElements
     * @param \Dywee\ProductBundle\Entity\PackElement $packElements
     * @return Product
     */
    public function addPackElement(\Dywee\ProductBundle\Entity\PackElement $packElements)
    {
        $this->packElements[] = $packElements;
        $packElements->setParent($this);

        return $this;
    }

    /**
     * Remove packElements
     * @param \Dywee\ProductBundle\Entity\PackElement $packElements
     */
    public function removePackElement(\Dywee\ProductBundle\Entity\PackElement $packElements){
        $this->packElements->removeElement($packElements);
        $packElements->setParent(null);
    }

    /**
     * Get packElements
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackElements(){
        return $this->packElements;
    }
}
