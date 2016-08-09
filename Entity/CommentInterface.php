<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 7/08/16
 * Time: 20:26
 */
namespace Dywee\ProductBundle\Entity;
use Dywee\UserBundle\Entity\User;

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
    public function getCreatedAt() : \DateTime;

    /**
     * @param $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt) : Comment;

    /**
     * @return BaseProduct
     */
    public function getProduct() : BaseProduct;

    /**
     * @param $product
     * @return Comment
     */
    public function setProduct($product) : Comment;

    /**
     * @return User
     */
    public function getUser() : User;

    /**
     * @param $user
     * @return Comment
     */
    public function setUser(User $user) : Comment;
}