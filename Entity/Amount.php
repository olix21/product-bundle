<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 5/09/17
 * Time: 20:19
 */

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Amount
 *
 * @package Dywee\ProductBundle\Entity
 *
 * @ORM\Entity()
 */
class Amount
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
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $value = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    private $currency = 'USD';

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }


    /**
     * @return float
     */
    public function getValue() : float
    {
        return $this->value;
    }

    /**
     * @param float $value
     *
     * @return Amount
     */
    public function setValue(float $value) : Amount
    {
        $this->value = $value;


        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Amount
     */
    public function setCurrency(string $currency) : Amount
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return int
     */
    public function getIntegerPart() : int
    {
        return (int) $this->getValue();
    }

    /**
     * @return int
     */
    public function getDecimalPart() : int
    {
        return ($this->getValue() - (int) $this->getValue()) * 100;
    }

    /**
     * @return string
     */
    public function getCurrencySymbol() : string
    {
        return '€';
    }

}