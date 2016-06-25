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
            if($product->getWebsite()->getId() != $this->container->getParameter('website.id'))
                throw $this->createNotFoundException('Ce produit est introuvable');

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

    public function adminViewAction(Product $product, Request $request)
    {
        if($product->getWebsite()->getId() != $request->getSession()->get('activeWebsite')->getId())
            throw $this->createNotFoundException('Ce produit est introuvable');

        $em = $this->getDoctrine()->getManager();
        $psr = $em->getRepository('DyweeProductBundle:ProductStat');

        $vues = $psr->getStats($product, 1);
        $baskets = $psr->getStats($product, 2);
        $ventes = $psr->getStats($product, 3);

        $stats = array();

        $date = new \DateTime("previous week");

        for($i = 0; $i <= 6; $i++)
        {
            $key = $date->modify('+1 day')->format('d/m/Y');
            $stats[$key] = array('createdDate' => $key, 'vues' => 0, 'basket' => 0, 'ventes' => 0);
        }

        //On organise les données des stats
        foreach($vues as $vue)
            $stats[$vue['createdDate']->format('d/m/Y')]['vues'] = $vue['total'];

        foreach($baskets as $basket)
            $stats[$basket['createdDate']->format('d/m/Y')]['basket'] = $basket['total'];

        foreach($ventes as $vente)
            $stats[$vente['createdDate']->format('d/m/Y')]['ventes'] = $vente['total'];

        //On instancie les données à transmettre à la vue
        $data = array('product' => $product, 'stats' => $stats);

        //On récupère les tresholds pour l'affichage colorisé du stock
        $pmr = $em->getRepository('DyweeCoreBundle:ParametersManager');
        $stockEnabled = $pmr->findOneByName('stockManagementEnabled');

        $data['stockEnabled'] = $stockEnabled->getValue();


        if($stockEnabled->getValue() == 1)
        {
            $stockWarning = $pmr->findOneByName('stockWarningTreshold');
            $stockAlert = $pmr->findOneByName('stockAlertTreshold');

            $data['stockWarning'] = $stockWarning->getValue();
            $data['stockAlert'] = $stockAlert->getValue();
        }

        return $this->render('DyweeProductBundle:Product:adminView.html.twig', $data);
    }

    public function addAction($type, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setProductType($type);

        $pmr = $em->getRepository('DyweeCoreBundle:ParametersManager');

        $stockEnabled = $pmr->findOneByName('stockManagementEnabled');

        if($stockEnabled->getValue() == 1)
        {
            $stockWarning = $pmr->findOneByName('stockWarningTreshold');
            $stockAlert = $pmr->findOneByName('stockAlertTreshold');

            $product->setStockAlertTreshold($stockAlert->getValue());
            $product->setStockWarningTreshold($stockWarning->getValue());
        }

        $form = $this->get('form.factory')->create(ProductType::class, $product);

        if($form->handleRequest($request)->isValid())
        {

            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Produit bien ajouté');

            return $this->redirect($this->generateUrl('dywee_product_table', array('type' => $product->getProductType())));
        }

        return $this->render('DyweeProductBundle:Product:add.html.twig', array('form' => $form->createView()));
    }

    public function updateAction(Product $product, Request $request)
    {
        if($product->getWebsite()->getId() != $request->getSession()->get('activeWebsite')->getId())
            throw $this->createNotFoundException('Ce produit est introuvable');

        $form = $this->get('form.factory')->create(ProductType::class, $product);

        if($form->handleRequest($request)->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Produit bien mis à jour');

            return $this->redirect($this->generateUrl('dywee_product_table', array('type' => $product->getProductType())));
        }

        return $this->render('DyweeProductBundle:Product:edit.html.twig', array('form' => $form->createView()));
    }

    public function tableAction($type, $page, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $pr = $em->getRepository('DyweeProductBundle:Product');

        $form = $this->get('form.factory')->create(ProductFilterType::class)
            ->add('chercher', SubmitType::class)
        ;

        $filterActive = false;

        if($form->handleRequest($request)->isValid())
        {
            // Le filtrage ne marche, sûrement du à la traduction

            /*$filterBuilder = $pr->createQueryBuilder('p');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

            $productList = $filterBuilder
                ->orderBy('p.name')
                ->getQuery()
                ->getResult();
            $filterActive = true;*/
            $productList = $pr->findBy(array('productType' => $type), array('name' => 'asc'));
        }
        else $productList = $pr->findBy(array('productType' => $type), array('name' => 'asc'));

        return $this->render('DyweeProductBundle:Product:table.html.twig', array(
            'productList' => $productList,
            'type' => $type,
            'search' => $form->createView(),
            'filterActive' => $filterActive
        ));
    }

    public function listAction($type = 1, $orderBy = null, $limit = null, $offset =0)
    {
        $em = $this->getDoctrine()->getManager();
        $pr = $em->getRepository('DyweeProductBundle:Product');

        $productList = $pr->getByDisplayOrder($type, $limit, $orderBy);

        return $this->render('DyweeProductBundle:Eshop:roughList.html.twig', array('productList' => $productList));
    }

    public function getListAction($type)
    {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('DyweeProductBundle:Product');

        $productList = $productRepository->findBy(
            array(
                'productType' => $type,
                'state' => 1,
            )
        );
        return $this->render('DyweeProductBundle:Eshop:roughList.html.twig', array('productList' => $productList));
    }

    public function deleteAction(Product $product)
    {
        if($product->getWebsite()->getId() != $this->get('session')->get('activeWebsite')->getId())
            throw $this->createNotFoundException('Ce produit est introuvable');

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Produit bien supprimée');

        return $this->redirect($this->generateUrl('dywee_product_table', array('type' => $product->getProductType())));
    }

    public function renderLastRentingAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $or = $em->getRepository('DyweeOrderBundle:OrderElement');

        $os = $or->findLastRentingByProduct($product);

        return $this->render('DyweeProductBundle:Product:rentMiniTable.html.twig', array('orderElementList' => $os));
    }
}
