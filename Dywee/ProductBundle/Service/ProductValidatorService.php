<?php
// src/Dywee/ProductBundle/Service/ProductValidatorService.php

namespace Dywee\ProductBundle\Service;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Dywee\NotificationBundle\Entity\Notification;
use Dywee\ProductBundle\Entity\Product;

class ProductValidatorService
{
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Product) {
            return;
        }

        $this->checkProductContent($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Product) {
            return;
        }

        $this->checkProductContent($args);
    }


    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Product) {
            return;
        }

        $stockManager = new StockManagerService($args->getEntityManager());
        $stockManager->checkProduct($entity);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Product) {
            return;
        }

        $stockManager = new StockManagerService($args->getEntityManager());
        $stockManager->checkProduct($entity);
    }

    public function checkProductContent($args)
    {
        $product = $args->getEntity();
        $em = $args->getEntityManager();

        if (!$product instanceof Product) {
            return;
        }

        if($product->getSeoUrl() == '')
        {
            $product->setSeoUrl($product->getSlug());

            $notificationSeoUrl = new Notification();
            $notificationSeoUrl->setBundle('product');
            $notificationSeoUrl->setType('product.seoUrl.missing');
            $notificationSeoUrl->setContent('L\url optimisée n\'a pas été renseignée, elle a été générée automatiquement');
            $notificationSeoUrl->setArgument1($product->getId());
            $notificationSeoUrl->setArgument2($product->getName());
            $notificationSeoUrl->setRoutingPath('dywee_product_admin_view');
            $notificationSeoUrl->setRoutingArguments('{"id": '.$product->getId().'}');

            $em->persist($notificationSeoUrl);

        }

        if($product->getMetaTitle() == '')
        {
            $product->setMetaTitle($product->setName());

            $notificationSeoTitle = new Notification();
            $notificationSeoTitle->setBundle('product');
            $notificationSeoTitle->setType('product.seoTitle.missing');
            $notificationSeoTitle->setContent('Le titre de la page produit n\'a pas été renseignée, il a été généré automatiquement');
            $notificationSeoTitle->setArgument1($product->getId());
            $notificationSeoTitle->setArgument2($product->getName());
            $notificationSeoTitle->setRoutingPath('dywee_product_admin_view');
            $notificationSeoTitle->setRoutingArguments('{"id": '.$product->getId().'}');

            $em->persist($notificationSeoTitle);
        }

        $em->flush();
    }
}