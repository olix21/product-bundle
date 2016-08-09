<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dywee\UserBundle\Entity\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Brand
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dywee\ProductBundle\Repository\CommentRepository")
 * @Vich\Uploadable
 */
class Comment implements CommentInterface
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
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="BaseProduct", inversedBy="comments")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
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
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt) : Comment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getProduct() : BaseProduct
    {
        return $this->product;
    }

    /**
     * @inheritdoc
     */
    public function setProduct($product) : Comment
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function setUser(User $user) : Comment
    {
        $this->user = $user;
        return $this;
    }
}
