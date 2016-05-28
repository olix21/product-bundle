<?php
// src/Dywee/ProductBundle/Service/StockManagerService.php

namespace Dywee\ProductBundle\Service;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Dywee\NotificationBundle\Entity\Alert;
use Dywee\NotificationBundle\Entity\Notification;
use Dywee\ProductBundle\Entity\Product;

class StockManagerService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function checkProduct(Product $product)
    {
        //$pmr = $this->em->getRepository('DyweeCoreBundle:ParametersManager');

        //$stockEnabled = $pmr->findOneByName('stockManagementEnabled');

        //Si la gestion des stocks est activée
        if(false/*$stockEnabled->getValue() == 1*/)
        {
            $stockWarning = $pmr->findOneByName('stockWarningTreshold');
            $stockAlert = $pmr->findOneByName('stockAlertTreshold');

            //On récupère l'alerte si déjà présentes concernant le stock du produit
            $ar = $this->em->getRepository('DyweeNotificationBundle:Alert');
            $alert = $ar->findOneBy(array('type' => 'product.stock.empty', 'argument1' => $product->getId()));

            //On créé une alerte si le stock est vide
            if($product->getStock() == 0)
            {
                //$product->setState(5);
                $alert = new Alert();
                $alert->setBundle('product');
                $alert->setType('product.stock.empty');
                $alert->setContent('Rupture de stock');
                $alert->setArgument1($product->getId());
                $alert->setArgument2($product->getName());
                $alert->setRoutingPath('dywee_product_admin_view');
                $alert->setRoutingArguments('{"id": '.$product->getId().'}');
                $this->em->persist($alert);
            }
            //Sinon on créé une notification fonction du treshold fixé dans l'admin
            else if($product->getStock() <= $product->getStockAlertTreshold())
            {
                $notification = new Notification();
                $notification->setBundle('product');
                $notification->setType('product.stock.alert');
                $notification->setContent('Rupture de stock imminente');
                $notification->setArgument1($product->getId());
                $notification->setArgument2($product->getName());
                $notification->setRoutingPath('dywee_product_admin_view');
                $notification->setRoutingArguments('{"id": '.$product->getId().'}');
                $this->em->persist($notification);

                //Si une alert existe on la supprime
                if($alert)
                    $this->em->remove($alert);
            }
            else if($product->getStock() <= $product->getStockWarningTreshold())
            {
                $notification = new Notification();
                $notification->setBundle('product');
                $notification->setType('product.stock.warning');
                $notification->setContent('Le stock diminue');
                $notification->setArgument1($product->getId());
                $notification->setArgument2($product->getName());
                $notification->setRoutingPath('dywee_product_admin_view');
                $notification->setRoutingArguments('{"id": '.$product->getId().'}');
                $this->em->persist($notification);

                //Si une alert existe on la supprime
                if($alert)
                    $this->em->remove($alert);
            }
            else if($alert)
                $this->em->remove($alert);
        }
        //Si la gestion des stocks est désactivée on supprime tout
        else{
            //Récup des alertes relatives au stock et suppression
            /*$ar = $this->em->getRepository('DyweeNotificationBundle:Alert');
            $as = $ar->findByType('product.stock.empty');
            foreach($as as $alert)
                $this->em->remove($alert);

            //Récup des notifications relatives au stock et suppression
            $nr = $this->em->getRepository('DyweeNotificationBundle:Notification');
            $ns = array_merge($nr->findByType('product.stock.alert'), $nr->findByType('product.stock.warning'));

            foreach($ns as $notification)
                $this->em->remove($notification);
            */
        }

        $this->em->flush();

    }

    public function checkProductContent(Product $product)
    {

    }

    public function checkAll()
    {
        $pmr = $this->em->getRepository('DyweeCoreBundle:ParametersManager');
        $pr = $this->em->getRepository('DyweeProductBundle:Product');
        $stockEnabled = $pmr->findOneByName('stockManagementEnabled');

        //Si la gestion des stocks est activée
        if($stockEnabled->getValue() == 1) {
            $ps = $pr->findAll();
            foreach($ps as $product)
                if($product->getSellType() < 3)
                    $this->checkProduct($product);
        }
    }

    public function removeNotifications(Product $product = null)
    {
        //Récup des alertes relatives au stock et suppression
        $ar = $this->em->getRepository('DyweeNotificationBundle:Alert');

        $data = array('type' => 'product.stock.empty');
        if($product)
            $data['argument1'] = $product->getId();
        $as = $ar->findBy($data);


        foreach($as as $alert)
            $this->em->remove($alert);

        //Récup des notifications relatives au stock et suppression
        $nr = $this->em->getRepository('DyweeNotificationBundle:Notification');
        $data = array();
        if($product)
            $data['argument1'] = $product->getId();
        $ns = array_merge(
            $nr->findBy(array_merge(
                array(
                    'type' => 'product.stock.alert',
                ),
                $data)
            ),
            $nr->findBy(array_merge(
                array(
                    'type' => 'product.stock.warning')
                ),
                $data)
            );

        foreach($ns as $notification)
            $this->em->remove($notification);

        $this->em->flush();
    }
}