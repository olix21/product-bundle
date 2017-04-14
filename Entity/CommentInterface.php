<?php

namespace Dywee\ProductBundle\Entity;

use Dywee\CoreBundle\Model\CustomerInterface;
use Dywee\CoreBundle\Model\ProductInterface;

interface CommentInterface
{
    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content);

    /**
     * @return int
     */
    public function getId();

    /**
     * @return \DateTime
     */
    public function getCreatedAt() : \DateTime;

    /**
     * @param \DateTime $createdAt
     *
     * @return Comment
     */
    public function setCreatedAt(\DateTime $createdAt) : Comment;

    /**
     * @return ProductInterface
     */
    public function getProduct() : ProductInterface;

    /**
     * @param ProductInterface $product
     *
     * @return Comment
     */
    public function setProduct(ProductInterface $product) : Comment;

    /**
     * @return CustomerInterface
     */
    public function getUser() : CustomerInterface;

    /**
     * @param $user
     *
     * @return Comment
     */
    public function setUser(CustomerInterface $user) : Comment;
}