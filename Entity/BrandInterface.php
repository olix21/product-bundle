<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 7/08/16
 * Time: 20:25
 */
namespace Dywee\ProductBundle\Entity;
use Symfony\Component\HttpFoundation\File\File;


interface BrandInterface
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
     * @return Brand
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null);

    /**
     * @return File
     */
    public function getImageFile();

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName);

    /**
     * @return string
     */
    public function getImageName();
}