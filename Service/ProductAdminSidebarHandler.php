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
            'icon' => 'fa fa-beer',
            'label' => 'Produits',
            'children' => array(
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Liste des produits',
                    'route' => $this->router->generate('product_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Liste des packs',
                    'route' => $this->router->generate('product_pack_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Listes des abonnements',
                    'route' => $this->router->generate('product_subscription_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Liste des services',
                    'route' => $this->router->generate('product_service_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Liste des catégories',
                    'route' => $this->router->generate('product_category_table')
                ),
                array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Liste des marques',
                    'route' => $this->router->generate('product_brand_table')
                ),
                /*array(
                    'icon' => 'fa fa-beer',
                    'label' => 'Liste des caractéristiques',
                    'route' => ''
                ),
                array(
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
