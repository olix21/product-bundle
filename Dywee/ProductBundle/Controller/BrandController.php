<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\Brand;
use Dywee\ProductBundle\Form\BrandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    public function tableAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $br = $em->getRepository('DyweeProductBundle:Brand');
        $brandList = $br->findAll();
        return $this->render('DyweeProductBundle:Brand:table.html.twig', array('brandList' => $brandList));
    }

    public function addAction(Request $request)
    {
        $brand = new Brand();

        $form = $this->get('form.factory')->create(new BrandType(), $brand);

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($brand);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Marque bien ajoutée');
            return $this->redirect($this->generateUrl('dywee_product_brand_table'));
        }
        return $this->render('DyweeProductBundle:Brand:add.html.twig', array('form' => $form->createView()));
    }

    public function updateAction(Brand $brand)
    {
        new Response('Controller à écrire');
    }

    public function deleteAction(Brand $brand)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($brand);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Marque bien supprimée');

        return $this->redirect($this->generateUrl('dywee_product_brand_table'));
    }

    public function viewProductsAction($data)
    {
        $em = $this->getDoctrine()->getManager();
        $br = $em->getRepository('DyweeProductBundle:Brand');
        $param = is_numeric($data)?array('id' => $data):array('name' => $data);
        $brand = $br->findOneBy($param);

        $pr = $em->getRepository('DyweeProductBundle:Product');
        $productList = $pr->findBy(
            array(
                'brand' => $brand
            )
        );

        if($brand !== null)
            return $this->render('DyweeProductBundle:Eshop:browseByBrand.html.twig', array('brand' => $brand, 'productList' => $productList));
        throw $this->createNotFoundException('Marque non trouvée');
    }
}
