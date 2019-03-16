<?php

namespace Dywee\ProductBundle\Service;

use Symfony\Component\Routing\RouterInterface;

class AdminDashboardHandler
{
    /** @var RouterInterface */
    private $router;

    /**
     * AdminDashboardHandler constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
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