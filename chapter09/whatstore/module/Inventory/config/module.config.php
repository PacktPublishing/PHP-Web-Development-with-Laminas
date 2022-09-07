<?php

declare(strict_types=1);

namespace Inventory;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Form\View\Helper\Form;
use Laminas\Form\View\Helper\FormCollection;
use Laminas\Form\View\Helper\FormSelect;
use Laminas\Form\View\Helper\FormNumber;
use Laminas\Form\View\Helper\FormHidden;
use Laminas\Form\View\Helper\FormText;
use Laminas\Form\View\Helper\FormLabel;
use Laminas\Form\View\Helper\FormPassword;

return [
    'router' => [
        'routes' => [
            'inventory' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/inventory[/:controller[/:action[/:key]]]',
                    'defaults' => [
                        'controller' => 'index',
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
            'index' => Controller\IndexController::class,
            'productapi' => Controller\ProductAPIController::class,
            'product' => Controller\ProductController::class,
            'discountapi' => Controller\DiscountAPIController::class,
            'discount' => Controller\DiscountController::class,
            'employeeapi' => Controller\EmployeeAPIController::class,
            'employee' => Controller\EmployeeController::class,
            'menu' => Controller\MenuController::class
        ],
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\ProductAPIController::class => Controller\ProductAPIControllerFactory::class,
            Controller\ProductController::class => Controller\ProductControllerFactory::class,
            Controller\DiscountAPIController::class => Controller\DiscountAPIControllerFactory::class,
            Controller\DiscountController::class => Controller\DiscountControllerFactory::class,
            Controller\EmployeeAPIController::class => Controller\EmployeeAPIControllerFactory::class,
            Controller\EmployeeController::class => Controller\EmployeeControllerFactory::class,
            Controller\MenuController::class => InvokableFactory::class
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
