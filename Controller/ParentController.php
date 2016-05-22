<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\CoreBundle\Doctrine\DQL\Date;
use Dywee\OrderBundle\Entity\BaseOrder;
use Dywee\ProductBundle\Entity\Product;
use Dywee\ProductBundle\Entity\ProductStat;
use Dywee\ProductBundle\Entity\ProductSubscription;
use Dywee\ProductBundle\Filter\ProductFilterType;
use Dywee\ProductBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ParentController extends \Dywee\CoreBundle\Controller\ParentController
{
    protected $bundleName = 'DyweeProductBundle';
}
