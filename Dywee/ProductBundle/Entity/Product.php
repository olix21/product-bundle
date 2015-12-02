<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product implements Translatable
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
     * @var integer
     *
     * @ORM\Column(name="productType", type="smallint")
     */
    private $productType;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", scale=2, nullable=true)
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPriceTTC", type="boolean", nullable=true)
     */
    private $isPriceTTC = true;

    /**
     * @var string
     *
     * @ORM\Column(name="recurrenceFreq", type="string", length=255, nullable=true)
     */
    private $recurrenceFreq;

    /**
     * @var string
     *
     * @ORM\Column(name="recurrence", type="smallint", nullable=true)
     */
    private $recurrence;

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
    private $sizeUnit = 'cm';

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
    private $weightUnit = 'gr';

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    /*
     * @ORM\Column(name="rentStock", type="smallint")
     */
    private $rentStock = 0;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\RentableProduct", mappedBy="parent", cascade={"persist", "remove"})
     */
    private $rentableProducts;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPromotion", type="boolean")
     */
    private $isPromotion = false;

    /**
     * @var string
     *
     * @ORM\Column(name="promotionPrice", type="decimal", scale=3, nullable=true)
     */
    private $promotionPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state = 1;

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
     * @var boolean
     *
     * @ORM\Column(name="sellType", type="smallint")
     */
    private $sellType = 2;

    /**
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\ProductImage", mappedBy="product", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\PackElement", mappedBy="parent", cascade={"persist", "remove"})
     */
    private $packElements;

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
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\ProductVariant", mappedBy="product", cascade={"persist", "remove"})
     */
    private $productVariants;

    /**
     * @ORM\Column(name="productVariationCounter", type="integer")
     */
    private $productVariationCounter = 0;

    /**
     * @ORM\OneToMany(targetEntity="Dywee\ProductBundle\Entity\ProductStat", mappedBy="product")
     */
    private $productStat;

    /**
     * @ORM\Column(name="externalDownloadLink", type="string", length=255, nullable=true)
     */
    private $externalDownloadLink;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\ModuleBundle\Entity\Event", inversedBy="products")
     */
    private $event;

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
     * Set productType
     *
     * @param integer $productType
     * @return Product
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * Get productType
     *
     * @return integer 
     */
    public function getProductType()
    {
        return $this->productType;
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
     * Set recurrenceFreq
     *
     * @param string $recurrenceFreq
     * @return Product
     */
    public function setRecurrenceFreq($recurrenceFreq)
    {
        $this->recurrenceFreq = $recurrenceFreq;

        return $this;
    }

    /**
     * Get recurrenceFreq
     *
     * @return string 
     */
    public function getRecurrenceFreq()
    {
        return $this->recurrenceFreq;
    }

    /**
     * Set recurrence
     *
     * @param integer $recurrence
     * @return Product
     */
    public function setRecurrence($recurrence)
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * Get recurrence
     *
     * @return integer 
     */
    public function getRecurrence()
    {
        return $this->recurrence;
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
     * Set isPromotion
     *
     * @param boolean $isPromotion
     * @return Product
     */
    public function setIsPromotion($isPromotion)
    {
        $this->isPromotion = $isPromotion;

        return $this;
    }

    /**
     * Get isPromotion
     *
     * @return boolean 
     */
    public function getIsPromotion()
    {
        return $this->isPromotion;
    }

    /**
     * Set promotionPrice
     *
     * @param string $promotionPrice
     * @return Product
     */
    public function setPromotionPrice($promotionPrice)
    {
        $this->promotionPrice = $promotionPrice;

        return $this;
    }

    /**
     * Get promotionPrice
     *
     * @return string 
     */
    public function getPromotionPrice()
    {
        return $this->promotionPrice;
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
     * Set isRentable
     *
     * @param boolean $isRentable
     * @return Product
     */
    public function setIsRentable($isRentable)
    {
        $this->isRentable = $isRentable;

        return $this;
    }

    /**
     * Get isRentable
     *
     * @return boolean 
     */
    public function getIsRentable()
    {
        return $this->isRentable;
    }

    /**
     * Add images
     *
     * @param \Dywee\ProductBundle\Entity\ProductImage $images
     * @return Product
     */
    public function addImage(\Dywee\ProductBundle\Entity\ProductImage $images)
    {
        $this->images[] = $images;
        $images->setProduct($this);
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Dywee\ProductBundle\Entity\ProductImage $images
     */
    public function removeImage(\Dywee\ProductBundle\Entity\ProductImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add products
     *
     * @param \Dywee\ProductBundle\Entity\Product $products
     * @return Product
     */
    public function addProduct(\Dywee\ProductBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Dywee\ProductBundle\Entity\Product $products
     */
    public function removeProduct(\Dywee\ProductBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
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
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }


    /**
     * Set sellType
     *
     * @param integer $sellType
     * @return Product
     */
    public function setSellType($sellType)
    {
        $this->sellType = $sellType;

        return $this;
    }

    /**
     * Get sellType
     *
     * @return integer 
     */
    public function getSellType()
    {
        return $this->sellType;
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

    /**
     * Add packElements
     *
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
     *
     * @param \Dywee\ProductBundle\Entity\PackElement $packElements
     */
    public function removePackElement(\Dywee\ProductBundle\Entity\PackElement $packElements)
    {
        $this->packElements->removeElement($packElements);
        $packElements->setParent(null);
    }

    /**
     * Get packElements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPackElements()
    {
        return $this->packElements;
    }

    public function displayPrice()
    {
        return ($this->getIsPromotion())?
            ('<small><strike>'.number_format($this->getPrice(),2).'€</strike></small> <big>'.number_format($this->getPromotionPrice(), 2).'€</big>'):
            number_format($this->getPrice(), 2).'€';
    }

    /**
     * Add rentableProducts
     *
     * @param \Dywee\ProductBundle\Entity\RentableProduct $rentableProducts
     * @return Product
     */
    public function addRentableProduct(\Dywee\ProductBundle\Entity\RentableProduct $rentableProducts)
    {
        $this->rentableProducts[] = $rentableProducts;
        $rentableProducts->setParent($this);

        return $this;
    }

    /**
     * Remove rentableProducts
     *
     * @param \Dywee\ProductBundle\Entity\RentableProduct $rentableProducts
     */
    public function removeRentableProduct(\Dywee\ProductBundle\Entity\RentableProduct $rentableProducts)
    {
        $this->rentableProducts->removeElement($rentableProducts);
    }

    /**
     * Get rentableProducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRentableProducts()
    {
        return $this->rentableProducts;
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
     * Set productVariationCounter
     *
     * @param integer $productVariationCounter
     *
     * @return Product
     */
    public function setProductVariationCounter($productVariationCounter)
    {
        $this->productVariationCounter = $productVariationCounter;

        return $this;
    }

    /**
     * Get productVariationCounter
     *
     * @return integer
     */
    public function getProductVariationCounter()
    {
        return $this->productVariationCounter;
    }

    /**
     * Add productVariant
     *
     * @param \Dywee\ProductBundle\Entity\ProductVariant $productVariant
     *
     * @return Product
     */
    public function addProductVariant(\Dywee\ProductBundle\Entity\ProductVariant $productVariant)
    {
        $this->productVariants[] = $productVariant;
        $productVariant->setProduct($this);

        return $this;
    }

    /**
     * Remove productVariant
     *
     * @param \Dywee\ProductBundle\Entity\ProductVariant $productVariant
     */
    public function removeProductVariant(\Dywee\ProductBundle\Entity\ProductVariant $productVariant)
    {
        $this->productVariants->removeElement($productVariant);
    }

    /**
     * Get productVariants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductVariants()
    {
        return $this->productVariants;
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

    public function setExternalDownloadLink($link)
    {
        $this->externalDownloadLink = $link;

        return $this;
    }

    public function getExternalDownloadLink()
    {
        return $this->externalDownloadLink;
    }

    /**
     * Set event
     *
     * @param \Dywee\ModuleBundle\Entity\Event $event
     * @return Product
     */
    public function setEvent(\Dywee\ModuleBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Dywee\ModuleBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
}
