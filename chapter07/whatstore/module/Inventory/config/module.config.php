<?php

declare(strict_types=1);

namespace Inventory;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'inventory' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/inventory[/:controller[/:action[/:key]]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index'
                    ],
                ],
            ],
            'inventoryapi' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/inventoryapi[/:controller[/:key]]'
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'productapi' => Controller\ProductAPIController::class,
            'product' => Controller\ProductController::class
        ],
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ProductAPIController::class => Controller\ProductAPIControllerFactory::class,
            Controller\ProductController::class => Controller\ProductControllerFactory::class,            
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
            'application/index/index' => __DIR__ . '/../view/inventory/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'ProductTable' => Model\ProductTableFactory::class,
            'DiscountTable' => Model\DiscountTableFactory::class,
            'InventoryTable' => Model\InventoryTableFactory::class,
            'EmployeeTable' => Model\EmployeeTableFactory::class
        ]
    ]
];
