<?php

namespace Dywee\ProductBundle\Entity;

use Dywee\UserBundle\Entity\UserInterface;

interface CommentInterface
{
    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
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
    public function getCreatedAt(): \DateTime;

    /**
     * @param $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt): Comment;

    /**
     * @return BaseProduct
     */
    public function getProduct(): BaseProduct;

    /**
     * @param $product
     * @return Comment
     */
    public function setProduct($product): Comment;

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * @param $user
     * @return Comment
     */
    public function setUser(UserInterface $user): Comment;
}