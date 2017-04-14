<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dywee\CoreBundle\Model\ProductInterface;
use Dywee\CoreBundle\Traits\NameableEntity;
use Dywee\CoreBundle\Traits\Seo;
use Dywee\CoreBundle\Traits\SizeableEntity;
use Dywee\CoreBundle\Traits\WeighableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * BaseProduct
 *
 * @ORM\Entity
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "product" = "Dywee\ProductBundle\Entity\Product",
 *     "productPack" = "Dywee\ProductBundle\Entity\ProductPack",
 *     "productSubscription" = "Dywee\ProductBundle\Entity\ProductSubscription",
 *     "productService" = "Dywee\ProductBundle\Entity\ProductService",
 *     "productDownloadable" = "Dywee\ProductBundle\Entity\ProductDownloadable",
 *     "rentableProduct" = "Dywee\ProductBundle\Entity\RentableProduct",
 *     "rentableProductItem" = "Dywee\ProductBundle\Entity\RentableProductItem",
 * })
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
abstract class BaseProduct implements Translatable, ProductInterface
{
    use Seo;
    use NameableEntity;
    use SizeableEntity;
    use WeighableEntity;
    use TimestampableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"list"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"list"})
     */
    private $price = 0;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPriceTTC = true;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"list"})
     */
    private $stock;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $stockWarningThreshold = null;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $stockAlertThreshold = null;

    /**
     * @var integer
     *
     * @ORM\Column(type="string", length=25)
     */
    private $state = self::STATE_AVAILABLE;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    private $mediumDescription;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
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
     * @ORM\Column(type="date", nullable=true)
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
     * @ORM\OneToMany(targetEntity="Promotion", mappedBy="product")
     */
    private $promotions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->relatedProducts = new ArrayCollection();
        $this->productStats = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->sizeUnit = self::SIZE_UNIT_MM;
        $this->weightUnit = self::WEIGHT_UNIT_GR;
        $this->features = new ArrayCollection();
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @inheritdoc
     */
    public function setIsPriceTTC($isPriceTTC)
    {
        $this->isPriceTTC = $isPriceTTC;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getIsPriceTTC()
    {
        return $this->isPriceTTC;
    }


    /**
     * @inheritdoc
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @inheritdoc
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @inheritdoc
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @inheritdoc
     */
    public function setMediumDescription($mediumDescription)
    {
        $this->mediumDescription = $mediumDescription;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMediumDescription()
    {
        return $this->mediumDescription;
    }

    /**
     * @inheritdoc
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @inheritdoc
     */
    public function setBrand(Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @inheritdoc
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
        $category->addProduct($this);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * @inheritdoc
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @inheritdoc
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @inheritdoc
     * @deprecated
     */
    public function displayPrice()
    {
        return number_format($this->getPrice(), 2) . ' €';
    }

    /**
     * @inheritdoc
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @inheritdoc
     */
    public function addFeature(FeatureElement $feature)
    {
        $this->features[] = $feature;
        $feature->setProduct($this);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeFeature(FeatureElement $feature)
    {
        $this->features->removeElement($feature);
    }

    /**
     * @inheritdoc
     */
    public function countCategories()
    {
        return count($this->getCategories());
    }

    /**
     * @inheritdoc
     */
    public function getCategory($data)
    {
        foreach ($this->getCategories() as $category) {
            if ($category->getParent()->getId() === $data)
                return $category;
        }
    }

    /**
     * @inheritdoc
     */
    public function setStockWarningThreshold($stockWarningThreshold)
    {
        $this->stockWarningThreshold = $stockWarningThreshold;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStockWarningThreshold()
    {
        return $this->stockWarningThreshold;
    }

    /**
     * @inheritdoc
     */
    public function setStockAlertThreshold($stockAlertThreshold)
    {
        $this->stockAlertThreshold = $stockAlertThreshold;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStockAlertThreshold()
    {
        return $this->stockAlertThreshold;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @inheritdoc
     */
    public function setAvailableAt($availableAt)
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAvailableAt()
    {
        return $this->availableAt;
    }

    /**
     * @inheritdoc
     */
    public function addProductStat(ProductStat $productStat)
    {
        $this->productStats[] = $productStat;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeProductStat(ProductStat $productStat)
    {
        $this->productStats->removeElement($productStat);
    }

    /**
     * @inheritdoc
     */
    public function getProductStats()
    {
        return $this->productStats;
    }

    /**
     * @inheritdoc
     */
    public function decreaseStock($quantity)
    {
        return $this->stockOperation($quantity, 'decrease');
    }

    /**
     * @inheritdoc
     */
    public function refundStock($quantity)
    {
        return $this->stockOperation($quantity, 'refund');
    }

    /**
     * @inheritdoc
     */
    public function stockOperation($quantity, $operation = 'decrease')
    {
        if ($operation === 'decrease') {
            $this->setStock($this->getStock() - $quantity);
        } elseif ($operation === 'refund') {
            $this->setStock($this->getStock() + $quantity);
        }

        return $this;
    }

    /** @deprecated Use getName instead */
    public function getCompleteName()
    {
        return $this->getName();
    }

    /**
     * @inheritdoc
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @inheritdoc
     */
    public function setDeletedAt(\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @inheritdoc
     */
    public function addPicture(ProductPicture $picture)
    {
        $this->pictures[] = $picture;
        $picture->setProduct($this);
    }

    /**
     * @inheritdoc
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @inheritdoc
     */
    public function removePicture(ProductPicture $picture)
    {
        $this->pictures->removeElement($picture);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function getConstantList()
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }


    /**
     * @inheritdoc
     */
    public function addRelatedProduct(ProductInterface $product)
    {
        $this->relatedProducts[] = $product;
        $product->setRelatedToProduct($this);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeRelatedProduct(ProductInterface $product)
    {
        $this->relatedProducts->removeElement($product);
    }

    /**
     * @inheritdoc
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }

    /**
     * @inheritdoc
     */
    public function setRelatedToProduct(ProductInterface $product)
    {
        $this->relatedToProduct = $product;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRelatedToProduct()
    {
        return $this->relatedToProduct;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        //if($this->getSeoUrl())
        //    return $this->getSeoUrl();

        return $this->getId();
    }

    /**
     * @inheritdoc
     */
    public function getMainPicture()
    {
        return $this->getPictures()[0];
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @inheritdoc
     */
    public function addComment(CommentInterface $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeComment(CommentInterface $comment)
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addPromotion(Promotion $promotion)
    {
        $this->promotions[] = $promotion;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @inheritdoc
     */
    public function removePromotion(Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
    }

    /**
     * @inheritdoc
     */
    public function getActivePromotion()
    {
        $activePromotions = [];

        foreach ($this->getPromotions() as $promotion) {
            if ($promotion->isActive()){
                $activePromotions[] = $promotion;
            }
        }

        return $activePromotions;
    }

    /**
     * @inheritdoc
     */
    public function isInPromotion()
    {
        return count($this->getActivePromotion()) > 0;
    }


}
