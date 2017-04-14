<?php

namespace Dywee\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dywee\CoreBundle\Model\CustomerInterface;
use Dywee\CoreBundle\Model\ProductInterface;
use Dywee\UserBundle\Entity\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Brand
 *
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="Dywee\CoreBundle\Model\ProductInterface", inversedBy="comments")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Dywee\CoreBundle\Model\CustomerInterface")
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
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt(\DateTime $createdAt): Comment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * @inheritdoc
     */
    public function setProduct(ProductInterface $product): Comment
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUser(): CustomerInterface
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function setUser(CustomerInterface $user): Comment
    {
        $this->user = $user;
        return $this;
    }
}
