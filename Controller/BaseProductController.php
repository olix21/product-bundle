<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\BaseProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseProductController extends Controller
{
    public function dashboardAction()
    {
        $baseProductRepository = $this->getDoctrine()->getRepository('DyweeProductBundle:BaseProduct');
        $products = $baseProductRepository->findAll();

        return $this->render('DyweeProductBundle:BaseProduct:dashboard.html.twig', array('products' => $products));
    }

    public function addAction()
    {

    }

    public function tableAction()
    {

    }

    public function viewAction()
    {

    }

    public function adminViewAction()
    {

    }

    public function updateAction()
    {

    }

    public function deleteAction(BaseProduct $baseProduct)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($baseProduct);
        $em->flush();

        return $this->redirectToRoute('product_table');
    }
}
