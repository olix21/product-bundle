<?php

namespace Dywee\ProductBundle\Listener;

use Dywee\CoreBundle\DyweeCoreEvent;
use Dywee\CoreBundle\Event\AdminSidebarBuilderEvent;
use Dywee\ProductBundle\Service\ProductAdminSidebarHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class AdminSidebarBuilderListener implements EventSubscriberInterface{
    private $productAdminSidebarHandler;

    public function __construct(ProductAdminSidebarHandler $productAdminSidebarHandler)
    {
        $this->productAdminSidebarHandler = $productAdminSidebarHandler;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            DyweeCoreEvent::BUILD_ADMIN_SIDEBAR => 'addElementToSidebar'
        );
    }

    public function addElementToSidebar(AdminSidebarBuilderEvent $adminSidebarBuilderEvent)
    {
        $adminSidebarBuilderEvent->addAdminElement($this->productAdminSidebarHandler->addSideBarMenuElementAction());
    }
}