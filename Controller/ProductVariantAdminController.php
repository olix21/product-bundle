<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\ProductOption;
use Dywee\ProductBundle\Form\ProductOptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductVariantAdminController extends AbstractController
{
    public function tableAction($idProduct)
    {
        $em = $this->getDoctrine()->getManager();

        $pvr = $em->getRepository('DyweeProductBundle:ProductVariant');

        $pvs = $pvr->findBy(array('product' => $idProduct));

        return $this->render('DyweeProductBundle:ProductVariant:admin_table.html.twig', array('productVariants' => $pvs));
    }
}
