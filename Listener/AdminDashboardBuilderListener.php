<?php

namespace Dywee\ProductBundle\Listener;

use Dywee\CoreBundle\DyweeCoreEvent;
use Dywee\CoreBundle\Event\DashboardBuilderEvent;
use Dywee\OrderBundle\Service\AdminDashboardHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class AdminDashboardBuilderListener implements EventSubscriberInterface
{
    private AdminDashboardHandler $productAdminDashboardHandler;

    public function __construct(AdminDashboardHandler $adminDashboardHandler)
    {
        $this->productAdminDashboardHandler = $adminDashboardHandler;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            DyweeCoreEvent::BUILD_ADMIN_DASHBOARD => ['addElementToDashboard', 2048]
        ];
    }

    /**
     * @param DashboardBuilderEvent $adminDashboardBuilderEvent
     */
    public function addElementToDashboard(DashboardBuilderEvent $adminDashboardBuilderEvent)
    {
        $adminDashboardBuilderEvent->addElement($this->productAdminDashboardHandler->getDashboardElement());
    }
}
