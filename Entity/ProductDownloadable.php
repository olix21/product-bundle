<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\ProductDownloadableRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductDownloadable extends BaseProduct
{

    /**
     * @ORM\Column(name="externalDownloadLink", type="string", length=255, nullable=true)
     */
    private $externalDownloadLink;

    public function setExternalDownloadLink($link){
        $this->externalDownloadLink = $link;
        return $this;
    }

    public function getExternalDownloadLink(){
        return $this->externalDownloadLink;
    }
}
