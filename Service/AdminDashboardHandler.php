<?php

namespace Dywee\OrderBundle\Service;

use Symfony\Component\Routing\Router;

class AdminDashboardHandler
{
    /** @var Router */
    private $router;

    /**
     * AdminDashboardHandler constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function getDashboardElement()
    {
        $elements = [
            'key'   => 'product',
            'cards' => [
                [
                    'controller' => 'DyweeProductBundle:Dashboard:card',
                ],
            ],
            'boxes' => [
                [
                    'column' => 'col-md-8',
                    'type'   => 'default',
                    'title'  => 'product.dashboard.table',
                    'body'   => [
                        [
                            'boxBody'    => false,
                            'controller' => 'DyweeProductBundle:Dashboard:table',
                        ],
                    ],
                ],
            ],
        ];

        return $elements;
    }
}
