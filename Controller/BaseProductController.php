<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\BaseProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseProductController extends Controller
{
    protected $childrenClassNameWithNamespace;
    protected $childrenClassName;


    public function __construct()
    {
        $this->childrenClassNameWithNamespace = str_replace('\\\\', '\Entity\\', str_replace(array('Controller'), '', get_class($this)));
        $exploded = explode('\\', $this->childrenClassNameWithNamespace);
        $this->childrenClassName = $exploded[count($exploded)-1];
    }

    public function dashboardAction()
    {
        $baseProductRepository = $this->getDoctrine()->getRepository('DyweeProductBundle:BaseProduct');
        $products = $baseProductRepository->findAll();

        return $this->render('DyweeProductBundle:BaseProduct:dashboard.html.twig', array('products' => $products));
    }

    public function addAction(Request $request)
    {
        $formTypeName = str_replace('Entity', 'Form', $this->childrenClassNameWithNamespace.'Type');

        $product = new $this->childrenClassNameWithNamespace();

        $form = $this->createForm($formTypeName, $product);

        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute(strtolower($this->childrenClassName).'_table');
        }

        return $this->render('DyweeProductBundle:'.$this->childrenClassName.':add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function tableAction()
    {
        $repository = $this->getDoctrine()->getRepository('DyweeProductBundle:'.$this->childrenClassName);
        $products = $repository->findAll();

        return $this->render('DyweeProductBundle:'.$this->childrenClassName.':table.html.twig', array(
            'products' => $products
        ));
    }

    public function viewAction(BaseProduct $baseProduct)
    {
        return $this->render('DyweeProductBundle:'.$this->childrenClassName.':view.html.twig', array(
            'product' => $baseProduct
        ));
    }

    public function adminViewAction(BaseProduct $baseProduct)
    {
        $stats = null;
        return $this->render('DyweeProductBundle:'.$this->childrenClassName.':adminView.html.twig', array(
            'product' => $baseProduct,
            'stats' => $stats
        ));
    }

    public function updateAction(BaseProduct $baseProduct, Request $request)
    {
        $formTypeName = str_replace('Entity', 'Form', $this->childrenClassNameWithNamespace.'Type');

        $form = $this->createForm($formTypeName, $baseProduct);

        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($baseProduct);
            $em->flush();

            return $this->redirectToRoute(strtolower($this->childrenClassName).'_table');
        }

        return $this->render('DyweeProductBundle:'.$this->childrenClassName.':add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction(BaseProduct $baseProduct)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($baseProduct);
        $em->flush();

        return $this->redirectToRoute(strtolower($this->childrenClassName).'_table');
    }
}
