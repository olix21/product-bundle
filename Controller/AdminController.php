<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\BaseProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function getSideBarMenuElementAction()
    {
        /*
         <li class="treeview">
    <a href="pages/widgets.html">
        <i class="fa fa-beer"></i> <span>Produits</span>
        {#<small class="label pull-right bg-green">new</small>#}
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ path('dywee_product_table') }}"><i class="fa fa-beer"></i> Liste des produits</a></li>
        <li><a href="{{ path('dywee_product_table', {type: 2}) }}"><i class="fa fa-beer"></i> Liste des packs</a></li>
        <li><a href="{{ path('dywee_product_table', {type: 3}) }}"><i class="fa fa-beer"></i> Liste des abonnements</a></li>
        <li><a href="{{ path('dywee_product_table', {type: 4}) }}"><i class="fa fa-beer"></i> Liste des services</a></li>
        <li><a href="{{ path('dywee_product_category_table') }}"><i class="fa fa-list-alt"></i> Liste des catégories</a></li>
        <li><a href="{{ path('dywee_product_brand_table') }}"><i class="fa fa-list-alt"></i> Liste des marques</a></li>
        <li><a href="{{ path('dywee_product_feature_table') }}"><i class="fa fa-list-alt"></i> Liste des caractéristiques</a></li>
        <li><a href="{{ path('dywee_product_option_table') }}"><i class="fa fa-list-alt"></i> Liste des options</a></li>
    </ul>
</li>
         */
        $menu = array(
            'icon' => 'beer',
            'label' => 'Produits',
            'children' => array()
        );
    }
}
