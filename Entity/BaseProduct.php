<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dywee\CoreBundle\Traits\Seo;
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
 *     "rentableProduct" = "RentableProduct",
 *     "rentableProductItem" = "RentableProductItem",
 * })
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */

abstract class BaseProduct implements Translatable
{
    use Seo;

    const STATE_HIDDEN = 'product.state.hidden';
    const STATE_AVAILABLE = 'product.state.available';
    const STATE_NOT_AVAILABLE_ANYMORE = 'product.state.not_available';
    const STATE_AVAILABLE_SOON = 'product.state.available_soon';
    const STATE_ONLY_IN_STORE = 'product.state.only_store';
    const STATE_STOCK_EMPTY = 'product.state.stock_empty';
    const STATE_ONLY_ON_WEB = 'product.state.only_web';

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
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price = 0;

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
     * @ORM\OneToMany(targetEntity="ProductStat", mappedBy="product")
     */
    private $productStats;

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

    /*
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct", inversedBy="relatedProducts")
     */
    private $relatedToProduct;

    /**
     * @ORM\OneToMany(targetEntity="BaseProduct", mappedBy="relatedToProduct")
     */
    private $relatedProducts;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="product")
     */
    private $comments;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->packElements = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->relatedProducts = new ArrayCollection();
        $this->productStats = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->comments = new ArrayCollection();
    }


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
     * @param decimal $price
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
     * @return decimal
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
     * Set brand
     *
     * @param Brand $brand
     * @return Product
     */
    public function setBrand(Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add categories
     *
     * @param Category $category
     * @return Product
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
        $category->addProduct($this);

        return $this;
    }

    /**
     * Remove categories
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
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
     * @param FeatureElement $feature
     *
     * @return Product
     */
    public function addFeature(FeatureElement $feature)
    {
        $this->features[] = $feature;
        $feature->setProduct($this);

        return $this;
    }

    /**
     * Remove feature
     *
     * @param FeatureElement $feature
     */
    public function removeFeature(FeatureElement $feature)
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
     * @param ProductStat $productStat
     * @return Product
     */
    public function addProductStat(ProductStat $productStat)
    {
        $this->productStats[] = $productStat;

        return $this;
    }

    /**
     * Remove productStat
     *
     * @param ProductStat $productStat
     */
    public function removeProductStat(ProductStat $productStat)
    {
        $this->productStats->removeElement($productStat);
    }

    /**
     * Get productStats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductStats()
    {
        return $this->productStats;
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

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add related product
     *
     * @param BaseProduct $product
     * @return Product
     */
    public function addRelatedProduct(BaseProduct $product)
    {
        $this->relatedProducts[] = $product;
        $product->setRelatedToProduct($this);

        return $this;
    }

    /**
     * Remove related product
     *
     * @param BaseProduct $product
     */
    public function removeRelatedProduct(BaseProduct $product)
    {
        $this->relatedProducts->removeElement($product);
    }

    /**
     * Get related products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }

    /**
     * @param BaseProduct $product
     * @return $this
     */
    public function setRelatedToProduct(BaseProduct $product)
    {
        $this->relatedToProduct = $product;
        return $this;
    }

    /**
     * @return BaseProduct
     */
    public function getRelatedToProduct()
    {
        return $this->relatedToProduct;
    }

    public function getUrl()
    {
        //if($this->getSeoUrl())
        //    return $this->getSeoUrl();

        return $this->getId();
    }

    public function getMainPicture()
    {
        return $this->getPictures()[0];
    }

    public function isInPromotion()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return BaseProduct
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        return $this;
    }

    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
        return $this;
    }

}
