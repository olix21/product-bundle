<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\OrderBundle\Entity\BaseOrder;
use Dywee\ProductBundle\Entity\Product;
use Dywee\ProductBundle\Entity\ProductStat;
use Dywee\ProductBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function viewAction($data, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pr = $em->getRepository('DyweeProductBundle:Product');
        $or = $em->getRepository('DyweeOrderBundle:BaseOrder');
        if(is_numeric($data))
            $product = $pr->findOneById($data);
        else $product = $pr->findBySeoUrl($data);


        if($product != null)
        {
            $productStat = new ProductStat();

            $productStat->setProduct($product);
            $productStat->setQuantity(1);
            $productStat->setType(1);


            if($product->getState() != 2)
            {
                $defaultData = array('quantity' => 1);
                $form = $this->createFormBuilder($defaultData)
                ->add('quantity',   'number')
                ->add('Ajouter au panier',     'submit')
                ->getForm();

                if($form->handleRequest($request)->isValid())
                {
                    $formData = $form->getData();
                    if(is_numeric($formData['quantity']))
                    {
                        $order = $request->getSession()->get('order');

                        if($order->getId() != null)
                            $order = $or->findOneById($order->getId());
                        else $order = new BaseOrder();
                        $order->addProduct($product, $formData['quantity']);

                        $productStat->setQuantity($formData['quantity']);
                        $productStat->setType(2);

                        $em->persist($order);
                        $em->persist($productStat);
                        $em->flush();

                        $this->get('session')->set('order', $order);

                        return $this->redirect($this->generateUrl('dywee_basket_view'));
                    }
                    else $this->get('session')->getFlashBag()->set('warning', 'Vous devez entrer un nombre');
                }

                $data = array('product' => $product, 'form' => $form->createView());
            }
            else
            {
                $data = array('product' => $product, 'message' => 'Ce produit est actuellement en rupture de stock');
            }

            $em->persist($productStat);
            $em->flush();


            if($product->getProductType() == 1)
            {
                $fr = $em->getRepository('DyweeProductBundle:FeatureElement');

                $fer = $em->getRepository('DyweeProductBundle:FeatureElement');

                $data['strong'] = $fer->findOneBy(array('product' => $product, 'feature' => $fr->findOneById(1)));

                return $this->render('DyweeProductBundle:Eshop:viewProduct.html.twig', $data);
            }
            else if($product->getProductType() == 2)
                return $this->render('DyweeProductBundle:Eshop:viewPack.html.twig', $data);
            else if($product->getProductType() == 3)
                return $this->render('DyweeProductBundle:Eshop:viewAbonnement.html.twig', $data);
        }
        throw $this->createNotFoundException('Produit sélectionné introuvable');

    }

    public function adminViewAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $psr = $em->getRepository('DyweeProductBundle:ProductStat');

        $vues = $psr->getStats($product, 1);
        $baskets = $psr->getStats($product, 2);
        $ventes = $psr->getStats($product, 3);

        $stats = array();

        foreach($vues as $vue)
            $stats[$vue['createdDate']->format('d/m/Y')] = array('createdDate' => $vue['createdDate'], 'vues' => $vue['total'], 'basket' => 0, 'ventes' => 0);

        foreach($baskets as $basket)
        {
            if(array_key_exists($basket['createdDate']->format('d/m/Y'), $stats))
                $stats[$basket['createdDate']->format('d/m/Y')]['basket'] = $basket['total'];
            else $stats[$basket['createdDate']->format('d/m/Y')] = array('createdDate' => $basket['createdDate'], 'vues' => 0, 'basket' => $basket['total'], 'ventes' => 0);
        }

        foreach($ventes as $vente)
        {
            if(array_key_exists($vente['createdDate']->format('d/m/Y'), $stats))
                $stats[$vente['createdDate']->format('d/m/Y')]['ventes'] = $vente['total'];
            else $stats[$vente['createdDate']->format('d/m/Y')] = array(
                'createdDate' => $vente['createdDate'],
                'vues' => 0,
                'basket' => 0,
                'ventes' => $vente['total']
            );
        }

        $data = array('product' => $product, 'stats' => $stats);

        return $this->render('DyweeProductBundle:Product:adminView.html.twig', $data);
    }

    public function addAction($type, Request $request)
    {
        $this->get('session')->set('KCFINDER', array('disabled' => false));

        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setProductType($type);

        $form = $this->get('form.factory')->create(new ProductType, $product);

        if($form->handleRequest($request)->isValid()){

            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Produit bien ajouté');

            return $this->redirect($this->generateUrl('dywee_product_table'));
        }

        return $this->render('DyweeProductBundle:Eshop:add.html.twig', array('form' => $form->createView()));
    }

    public function updateAction(Product $product, Request $request)
    {
        $form = $this->get('form.factory')->create(new ProductType(), $product);

        if($form->handleRequest($request)->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Produit bien mis à jour');

            return $this->redirect($this->generateUrl('dywee_product_table', array('type' => $product->getProductType())));
        }

        return $this->render('DyweeProductBundle:Eshop:edit.html.twig', array('form' => $form->createView()));
    }

    public function tableAction($type, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $pr = $em->getRepository('DyweeProductBundle:Product');
        $productList = $pr->findBy(array('productType' => $type), array('name' => 'asc'));
        return $this->render('DyweeProductBundle:Product:table.html.twig', array('productList' => $productList, 'type' => $type));
    }

    public function listAction($type = 1, $orderBy = null, $limit = null, $offset =0)
    {
        $pr = $this->getDoctrine()->getManager()->getRepository('DyweeProductBundle:Product');
        $productList = $pr->getByDisplayOrder($type, $limit, $orderBy);

        return $this->render('DyweeProductBundle:Eshop:roughList.html.twig', array('productList' => $productList));
    }

    public function getListAction($type)
    {
        $pr = $this->getDoctrine()->getManager()->getRepository('DyweeProductBundle:Product');
        $productList = $pr->findBy(
            array(
                'productType' => $type,
                'state' => 1
            )
        );
        return $this->render('DyweeProductBundle:Eshop:roughList.html.twig', array('productList' => $productList));
    }

    public function deleteAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Produit bien supprimée');

        return $this->redirect($this->generateUrl('dywee_product_table', array('type' => $product->getProductType())));
    }
}
