<?php

declare(strict_types=1);

namespace Store;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Form\View\Helper\FormFile;
use Laminas\Form\View\Helper\FormEmail;
use Store\Model\IdentityManager;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],            
            'store' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/store[/:controller[/:action[/:key]]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'storeapi' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/storeapi[/:controller[/:key]]',
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'customer' => Controller\CustomerController::class,
            'customerapi' => Controller\CustomerAPIController::class,
            'productbasket' => Controller\ProductBasketController::class,
            'productbasketapi' => Controller\ProductBasketAPIController::class,
            'order' => Controller\OrderController::class,
            'orderapi' => Controller\OrderAPIController::class
        ],
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\CustomerController::class => Controller\CustomerControllerFactory::class,
            Controller\CustomerAPIController::class => Controller\CustomerAPIControllerFactory::class,
            Controller\ProductBasketController::class => Controller\ProductBasketControllerFactory::class,
            Controller\ProductBasketAPIController::class => Controller\ProductBasketAPIControllerFactory::class,
            Controller\OrderController::class => Controller\OrderControllerFactory::class,
            Controller\OrderAPIController::class => Controller\OrderAPIControllerFactory::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'store/index/index' => __DIR__ . '/../view/store/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'CustomerTable' => Model\CustomerTableFactory::class,
            'ProductBasket' => Model\ProductBasketFactory::class,
            'PurchaseOrderTable' => Model\PurchaseOrderTableFactory::class,
            'OrderItemTable' => Model\OrderItemTableFactory::class,
            IdentityManager::class => Model\IdentityManagerFactory::class
        ]
    ]
];
