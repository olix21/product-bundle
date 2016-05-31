<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\Brand;
use Dywee\ProductBundle\Form\BrandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends ParentController
{
    protected $tableViewName = 'product_brand_table';
}
