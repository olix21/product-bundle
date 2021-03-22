<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\BaseProduct;
use Dywee\ProductBundle\Form\BaseProductSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseProductController extends AbstractController
{
    protected $childrenClassNameWithNamespace;
    protected $childrenClassName;
    protected $childrenClassNameUnderscored;


    public function __construct()
    {
        $this->getObjectNames();
    }

    public function getObjectNames($object = null)
    {
        $this->childrenClassNameWithNamespace = str_replace('\\\\', '\Entity\\', str_replace(array('Controller'), '', get_class($object ?? $this)));
        $exploded = explode('\\', $this->childrenClassNameWithNamespace);
        $this->childrenClassName = $exploded[count($exploded) - 1];

        //To underscore
        $split = str_split($this->childrenClassName);
        $return = '';
        foreach ($split as $letter) {
            if (ctype_upper($letter) && strlen($return) > 1) {
                $return .= '_';
            }
            $return .= $letter;
        }
        $this->childrenClassNameUnderscored = strtolower($return);
    }


    public function dashboardAction(Request $request)
    {
        $baseProductRepository = $this->getDoctrine()->getRepository('DyweeProductBundle:BaseProduct');
        $products = $baseProductRepository->findAll();

        if ($request->isXmlHttpRequest()) {
            return new Response(json_encode(array('products' => $products)));
        }

        return $this->render('@DyweeProductBundle/BaseProduct/dashboard.html.twig', array('products' => $products));
    }

    public function addAction(Request $request)
    {
        $formTypeName = str_replace('Entity', 'Form', $this->childrenClassNameWithNamespace . 'Type');

        $product = new $this->childrenClassNameWithNamespace();

        $form = $this->createForm($formTypeName, $product);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return new Response(array('type' => 'success', 'redirectTo' => $this->generateUrl(strtolower($this->childrenClassNameUnderscored) . '_table')));
            }

            return $this->redirectToRoute(strtolower($this->childrenClassNameUnderscored) . '_table');
        }

        if ($request->isXmlHttpRequest()) {
            return new Response(array('form' => $form->createView()));
        }

        return $this->render('@DyweeProductBundle/' . $this->childrenClassName . '/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function tableAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('DyweeProductBundle:' . $this->childrenClassName);

        $product = new $this->childrenClassNameWithNamespace();
        $product->setState(null);

        $searchForm = $this->createForm(BaseProductSearchType::class, $product);

        if ($searchForm->handleRequest($request)->isValid()) {
            $products = $repository->findAll();
        } else {
            $products = $repository->findAll();
        }

        if ($request->isXmlHttpRequest()) {
            return new Response(array('type' => 'success', 'products' => $products));
        }

        return $this->render('@DyweeProductBundle/' . $this->childrenClassName . '/table.html.twig', array(
            'products' => $products,
            'search' => $searchForm->createView()
        ));
    }

    public function adminViewAction(BaseProduct $baseProduct)
    {
        return $this->render('@DyweeProductBundle/' . $this->childrenClassName . '/view.html.twig', array(
            'product' => $baseProduct,
            'stats' => $this->get('dywee_product_cms.stat_manager')->getForProduct($baseProduct)
        ));
    }

    public function updateAction(BaseProduct $baseProduct, Request $request)
    {
        $this->getObjectNames($baseProduct);
        $formTypeName = str_replace('Entity', 'Form', $this->childrenClassNameWithNamespace . 'Type');

        $form = $this->createForm($formTypeName, $baseProduct);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($baseProduct);
            $em->flush();

            return $this->redirectToRoute(strtolower($this->childrenClassNameUnderscored) . '_table');
        }

        return $this->render('@DyweeProductBundle/' . $this->childrenClassName . '/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction(BaseProduct $baseProduct)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($baseProduct);
        $em->flush();

        return $this->redirectToRoute(strtolower($this->childrenClassName) . '_table');
    }
}
