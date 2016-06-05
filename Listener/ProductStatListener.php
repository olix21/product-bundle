<?php

namespace Dywee\ProductBundle\Listener;

use Dywee\ProductBundle\DyweeProductEvent;
use Dywee\ProductBundle\Event\ProductStatEvent;
use Dywee\ProductBundle\Service\ProductStatManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Router;


class ProductStatListener implements EventSubscriberInterface{

    private $productStatManager;

    public function __construct(ProductStatManager $productStatManager)
    {
        $this->productStatManager = $productStatManager;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            DyweeProductEvent::PRODUCT_PAGE_DISPLAY => array('handleStat'),
            //TODO: listen to "Add to basket" and "validate order"
        );
    }

    public function handleStat(ProductStatEvent $productStatEvent)
    {
        $this->productStatManager->createStatForDisplay($productStatEvent->getProduct());
    }
}