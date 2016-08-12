<?php

namespace Dywee\ProductBundle\Service;

use Symfony\Component\Routing\Router;

class ProductAdminSidebarHandler
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function addSideBarMenuElementAction()
    {
        $ecommerceMenu = array(
            'key' => 'product',
            'icon' => 'fa fa-beer',
            'label' => 'product.sidebar.label',
            'children' => array(
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'product.list',
                    'route' => $this->router->generate('product_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'pack.lists',
                    'route' => $this->router->generate('product_pack_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'subscription.list',
                    'route' => $this->router->generate('product_subscription_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'service.list',
                    'route' => $this->router->generate('product_service_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'brand.list',
                    'route' => $this->router->generate('product_brand_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'product_category.list',
                    'route' => $this->router->generate('product_category_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'product_feature.list',
                    'route' => $this->router->generate('product_feature_table')
                ),
                /*array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Listes des options',
                    'route' => ''
                ),*/
            )
        );

        //$sidebar['admin'][] = $ecommerceMenu;
        return $ecommerceMenu;
    }
}
