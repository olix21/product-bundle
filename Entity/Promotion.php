<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dywee\CoreBundle\Traits\NameableEntity;
use Dywee\CoreBundle\Traits\TimeDelimitableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Promotion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\PromotionRepository")
 */
class Promotion
{
    const TYPE_AMOUNT   = 'amount';
    const TYPE_PERCENT  = 'percent';
    const TYPE_PRODUCT  = 'product';

    use NameableEntity;
    use TimestampableEntity;
    use TimeDelimitableEntity;

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
     * @ORM\Column(type="string", length=20)
     */
    private $type = self::TYPE_PERCENT;
    
    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct", inversedBy="promotions")
     */
    private $product;


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Promotion
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Promotion
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     * @return Promotion
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }



}
