<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 7/08/16
 * Time: 20:30
 */
namespace Dywee\ProductBundle\Entity;


interface CategoryInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set enableMulti
     *
     * @param boolean $enableMulti
     * @return Category
     */
    public function setEnableMulti($enableMulti);

    /**
     * Get enableMulti
     *
     * @return boolean
     */
    public function getEnableMulti();

    /**
     * Set parentCategory
     *
     * @param Category $parent
     * @return Category
     */
    public function setParent(Category $parent = null);

    /**
     * Get parentCategory
     *
     * @return \Dywee\ProductBundle\Entity\Category
     */
    public function getParent();

    /**
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position);

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition();

    /**
     * Add children
     *
     * @param Category $child
     * @return Category
     */
    public function addChildCategory(Category $child);

    /**
     * Remove children
     *
     * @param Category $child
     */
    public function removeChildCategory(Category $child);

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren();

    /**
     * Set visible
     *
     * @param boolean $enabled
     * @return Category
     */
    public function setEnabled($enabled);

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function isEnabled();

    public function sortChildCategories();

    /**
     * Add product
     *
     * @param BaseProduct $product
     *
     * @return Category
     */
    public function addProduct(BaseProduct $product);

    /**
     * Remove product
     *
     * @param BaseProduct $product
     */
    public function removeProduct(BaseProduct $product);

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct();

    /**
     * Set seoUrl
     *
     * @param string $seoUrl
     *
     * @return Category
     */
    public function setSeoUrl($seoUrl);

    /**
     * Get seoUrl
     *
     * @return string
     */
    public function getSeoUrl();

    public function getUrl();

    /**
     * Add child
     *
     * @param Category $child
     *
     * @return Category
     */
    public function addChild(Category $child);

    /**
     * Remove child
     *
     * @param Category $child
     */
    public function removeChild(Category $child);

    public function getIndentedName();
}
