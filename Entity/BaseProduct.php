<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * BaseProduct
 *
 * @ORM\Entity
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "product" = "Product",
 *     "productPack" = "ProductPack",
 *     "productSubscription" = "ProductSubscription",
 *     "productService" = "ProductService",
 *     "productDownloadable" = "ProductDownloadable",
 * })
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
abstract class BaseProduct implements Translatable
{
    const STATE_HIDDEN = 'product.state_hidden';
    const STATE_AVAILABLE = 'product_state_available';
    const STATE_NOT_AVAILABLE_ANYMORE = 'product.not_available';
    const STATE_AVAILABLE_SOON = 'product.available_soon';
    const STATE_ONLY_IN_STORE = 'product.only_store';
    const STATE_STOCK_EMPTY = 'product.stock_empty';
    const STATE_ONLY_ON_WEB = 'product.only_web';

    const SIZE_UNIT_MM = 'mm';
    const SIZE_UNIT_CM = 'cm';
    const SIZE_UNIT_METER = 'm';

    const WEIGHT_UNIT_GR = 'gr';
    const WEIGHT_UNIT_KG = 'kg';


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
     * @ORM\Column(name="price", type="decimal", scale=2, nullable=true)
     */
    private $price;

    /**
     * @var boolean
     * @ORM\Column(name="isPriceTTC", type="boolean", nullable=true)
     */
    private $isPriceTTC = true;

    /**
     * @var string
     *
     * @ORM\Column(name="length", type="decimal", scale=3, nullable=true)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="decimal", scale=3, nullable=true)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="decimal", scale=3, nullable=true)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="sizeUnit", type="string", length=255)
     */
    private $sizeUnit = self::SIZE_UNIT_MM;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="decimal", scale=3, nullable=true)
     */
    private $weight = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="weightUnit", type="string", length=255)
     */
    private $weightUnit = self::WEIGHT_UNIT_GR;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="string", length=25)
     */
    private $state = self::STATE_AVAILABLE;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="shortDescription", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="mediumDescription", type="text", nullable=true)
     */
    private $mediumDescription;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="longDescription", type="text", nullable=true)
     */
    private $longDescription;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="metaTitle", type="string", length=255, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="metaDescription", type="text", nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="seoUrl", type="string", length=255, nullable=true)
     */
    private $seoUrl;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="metaKeywords", type="text", nullable=true)
     */
    private $metaKeywords;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\ProductBundle\Entity\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="Dywee\ProductBundle\Entity\Category", inversedBy="product")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\FeatureElement", mappedBy="product", cascade={"persist", "remove"})
     */
    private $features;

    /**
     * @ORM\OneToMany(targetEntity="PackElement", mappedBy="product")
     */
    private $packElements;

    /**
     * @ORM\Column(name="displayOrder", type="smallint", nullable = true)
     */
    //Retiens l'ordonnancement d'affichage des produits
    private $displayOrder = 0;

    /**
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="stockWarningTreshold", type="smallint", nullable=true)
     */
    private $stockWarningTreshold = null;

    /**
     * @ORM\Column(name="stockAlertTreshold", type="smallint", nullable=true)
     */
    private $stockAlertTreshold = null;

    /**
     * @ORM\Column(name="availableAt", type="date", nullable=true)
     */
    private $availableAt;

    /**
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\ProductStat", mappedBy="product")
     */
    private $productStat;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="ProductPicture", mappedBy="product", cascade={"persist"})
     */
    private $pictures;






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
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isPriceTTC
     *
     * @param boolean $isPriceTTC
     * @return Product
     */
    public function setIsPriceTTC($isPriceTTC)
    {
        $this->isPriceTTC = $isPriceTTC;

        return $this;
    }

    /**
     * Get isPriceTTC
     *
     * @return boolean
     */
    public function getIsPriceTTC()
    {
        return $this->isPriceTTC;
    }

    /**
     * Set length
     *
     * @param string $length
     * @return Product
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set width
     *
     * @param string $width
     * @return Product
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return Product
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set sizeUnit
     *
     * @param string $sizeUnit
     * @return Product
     */
    public function setSizeUnit($sizeUnit)
    {
        $this->sizeUnit = $sizeUnit;

        return $this;
    }

    /**
     * Get sizeUnit
     *
     * @return string
     */
    public function getSizeUnit()
    {
        return $this->sizeUnit;
    }

    /**
     * Set weight
     *
     * @param string $weight
     * @return Product
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set weightUnit
     *
     * @param string $weightUnit
     * @return Product
     */
    public function setWeightUnit($weightUnit)
    {
        $this->weightUnit = $weightUnit;

        return $this;
    }

    /**
     * Get weightUnit
     *
     * @return string
     */
    public function getWeightUnit()
    {
        return $this->weightUnit;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Product
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Product
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set mediumDescription
     *
     * @param string $mediumDescription
     * @return Product
     */
    public function setMediumDescription($mediumDescription)
    {
        $this->mediumDescription = $mediumDescription;

        return $this;
    }

    /**
     * Get mediumDescription
     *
     * @return string
     */
    public function getMediumDescription()
    {
        return $this->mediumDescription;
    }

    /**
     * Set longDescription
     *
     * @param string $longDescription
     * @return Product
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Get longDescription
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return Product
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Product
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set seoUrl
     *
     * @param string $seoUrl
     * @return Product
     */
    public function setSeoUrl($seoUrl)
    {
        $this->seoUrl = $seoUrl;

        return $this;
    }

    /**
     * Get seoUrl
     *
     * @return string
     */
    public function getSeoUrl()
    {
        return $this->seoUrl;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return Product
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set brand
     *
     * @param \Dywee\ProductBundle\Entity\Brand $brand
     * @return Product
     */
    public function setBrand(\Dywee\ProductBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Dywee\ProductBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add categories
     *
     * @param \Dywee\ProductBundle\Entity\Category $categories
     * @return Product
     */
    public function addCategory(\Dywee\ProductBundle\Entity\Category $category)
    {
        $this->categories[] = $category;
        $category->addProduct($this);

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Dywee\ProductBundle\Entity\Category $categories
     */
    public function removeCategory(\Dywee\ProductBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->packElements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getUrl()
    {
        if($this->getSeoUrl() !== null && $this->getSeoUrl() != '')
            return $this->getSeoUrl();
        else return $this->getId();
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function displayPrice()
    {
        return number_format($this->getPrice(), 2).' €';
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set displayOrder
     *
     * @param integer $displayOrder
     *
     * @return Product
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    /**
     * Get displayOrder
     *
     * @return integer
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * Add feature
     *
     * @param \Dywee\ProductBundle\Entity\FeatureElement $feature
     *
     * @return Product
     */
    public function addFeature(\Dywee\ProductBundle\Entity\FeatureElement $feature)
    {
        $this->features[] = $feature;
        $feature->setProduct($this);

        return $this;
    }

    /**
     * Remove feature
     *
     * @param \Dywee\ProductBundle\Entity\FeatureElement $feature
     */
    public function removeFeature(\Dywee\ProductBundle\Entity\FeatureElement $feature)
    {
        $this->features->removeElement($feature);
    }

    public function countCategories()
    {
        return count($this->getCategories());
    }

    public function getCategory($data)
    {
        foreach($this->getCategories() as $category)
        {
            if($category->getParent()->getId() == $data)
                return $category;
        }
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set stockWarningTreshold
     *
     * @param integer $stockWarningTreshold
     *
     * @return Product
     */
    public function setStockWarningTreshold($stockWarningTreshold)
    {
        $this->stockWarningTreshold = $stockWarningTreshold;

        return $this;
    }

    /**
     * Get stockWarningTreshold
     *
     * @return integer
     */
    public function getStockWarningTreshold()
    {
        return $this->stockWarningTreshold;
    }

    /**
     * Set stockAlertTreshold
     *
     * @param integer $stockAlertTreshold
     *
     * @return Product
     */
    public function setStockAlertTreshold($stockAlertTreshold)
    {
        $this->stockAlertTreshold = $stockAlertTreshold;

        return $this;
    }

    /**
     * Get stockAlertTreshold
     *
     * @return integer
     */
    public function getStockAlertTreshold()
    {
        return $this->stockAlertTreshold;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set availableAt
     *
     * @param \DateTime $availableAt
     *
     * @return Product
     */
    public function setAvailableAt($availableAt)
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    /**
     * Get availableAt
     *
     * @return \DateTime
     */
    public function getAvailableAt()
    {
        return $this->availableAt;
    }


    /**
     * Add productStat
     *
     * @param \Dywee\ProductBundle\Entity\ProductStat $productStat
     * @return Product
     */
    public function addProductStat(\Dywee\ProductBundle\Entity\ProductStat $productStat)
    {
        $this->productStat[] = $productStat;

        return $this;
    }

    /**
     * Remove productStat
     *
     * @param \Dywee\ProductBundle\Entity\ProductStat $productStat
     */
    public function removeProductStat(\Dywee\ProductBundle\Entity\ProductStat $productStat)
    {
        $this->productStat->removeElement($productStat);
    }

    /**
     * Get productStat
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductStat()
    {
        return $this->productStat;
    }

    public function decreaseStock($quantity)
    {
        return $this->stockOperation($quantity, 'decrease');
    }

    public function refundStock($quantity)
    {
        return $this->stockOperation($quantity, 'refund');
    }

    public function stockOperation($quantity, $operation = 'decrease')
    {
        if($this->getProductType() == 1)
            if($operation == 'decrease')
                $this->setStock($this->getStock() - $quantity);
            elseif($operation == 'refund')
                $this->setStock($this->getStock() + $quantity);
        else{
            // Si la gestion du stock est activée pour le produit ( != null)
            if(is_numeric($this->getStock()))
                if($operation == 'decrease')
                    $this->setStock($this->getStock() - $quantity);
                elseif($operation == 'refund')
                    $this->setStock($this->getStock() + $quantity);

            // Puis on gère le stock pour les produits contenus dans l'abonnement ou le pack
            foreach($this->getPackElements() as $element)
            {
                $productFromPack = $element->getProduct();
                $productFromPack->stockOperation($quantity*$element->getQuantity(), $operation);
            }

        }
        return $this;
    }

    /** @deprecated Use getName instead */
    public function getCompleteName()
    {
        return $this->getName();
    }

    /**
     * @return array
     */
    public function getPackElements(){
        return $this->packElements;
    }

    /**
     * @param PackElement $packElement
     * @return Product
     */
    public function addPackElement(PackElement $packElement)
    {
        $this->packElements[] = $packElement;
        $packElement->setProduct($this);
        return $this;
    }

    public function removePackElement(PackElement $packElement)
    {
        $this->packElements->removeElement($packElement);
        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function addPicture(ProductPicture $picture)
    {
        $this->pictures[] = $picture;
        $picture->setProduct($this);
    }

    public function getPictures()
    {
        return $this->pictures;
    }

    public function removePicture(ProductPicture $picture)
    {
        $this->pictures->removeElement($picture);
        return $this;
    }

    static function getConstantList()
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }


}