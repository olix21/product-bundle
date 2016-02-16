<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\ProductOption;
use Dywee\ProductBundle\Form\ProductOptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionController extends Controller
{
    public function indexAction()
    {
        return new Response("ProductOptionController:indexAction");
    }

    public function viewAction($data, Request $request)
    {

    }

    public function addAction(Request $request)
    {
        $productOption = new ProductOption();

        $form = $this->get('form.factory')->create(new ProductOptionType, $productOption);
        $form->add('Valider', 'submit');

        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productOption);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Option de variante de produit bien ajoutée');

            return $this->redirect($this->generateUrl('dywee_product_option_table'));
        }

        return $this->render('DyweeProductBundle:ProductOption:add.html.twig', array('form' => $form->createView()));
    }

    public function updateAction($id, Request $request)
    {
        /*$this->get('session')->set('KCFINDER', array('disabled' => false));

        $em = $this->getDoctrine()->getManager();
        $pr = $em->getRepository('DyweeProductBundle:Product');
        $product = $pr->findOneById($id);

        if($product !== null){

            $_SESSION['KCFINDER'] = array('disabled' => false);

            $form = $this->get('form.factory')->create(new ProductType(), $product);

            if($form->handleRequest($request)->isValid()){
                $em->persist($product);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'Produit bien mis à jour');

                return $this->redirect($this->generateUrl('dywee_product_table', array('type' => $product->getProductType())));
            }

            return $this->render('DyweeProductBundle:Eshop:edit.html.twig', array('form' => $form->createView()));
        }
        throw $this->createNotFoundException('Ce produit n\'existe pas');*/

    }

    public function tableAction()
    {
        $em = $this->getDoctrine()->getManager();

        $por = $em->getRepository('DyweeProductBundle:ProductOption');
        $productOptionList = $por->findAll();
        return $this->render('DyweeProductBundle:ProductOption:table.html.twig', array('productOptionList' => $productOptionList));
    }

    public function deleteAction(ProductOption $productOption)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($productOption);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Option de variante de produit bien supprimée');

        return $this->redirect($this->generateUrl('dywee_product_option_table'));
    }
}
