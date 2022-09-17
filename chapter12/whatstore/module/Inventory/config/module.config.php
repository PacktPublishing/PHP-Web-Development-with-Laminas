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
            'menu' => Controller\MenuController::class,
            'role' => Controller\RoleController::class,
            'roleapi' => Controller\RoleAPIController::class,
            'resource' => Controller\ResourceController::class,
            'resourceapi' => Controller\ResourceAPIController::class,
            'roleresource' => Controller\RoleResourceController::class,
            'roleresourceapi' => Controller\RoleResourceAPIController::class,
            'employeerole' => Controller\EmployeeRoleController::class,
            'employeeroleapi' => Controller\EmployeeRoleAPIController::class,
            'inventory' => Controller\InventoryController::class,
            'inventoryapi' => Controller\InventoryAPIController::class
        ],
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\ProductAPIController::class => Controller\ProductAPIControllerFactory::class,
            Controller\ProductController::class => Controller\ProductControllerFactory::class,
            Controller\DiscountAPIController::class => Controller\DiscountAPIControllerFactory::class,
            Controller\DiscountController::class => Controller\DiscountControllerFactory::class,
            Controller\EmployeeAPIController::class => Controller\EmployeeAPIControllerFactory::class,
            Controller\EmployeeController::class => Controller\EmployeeControllerFactory::class,
            Controller\MenuController::class => InvokableFactory::class,
            Controller\RoleController::class => Controller\RoleControllerFactory::class,
            Controller\RoleAPIController::class => Controller\RoleAPIControllerFactory::class,
            Controller\ResourceController::class => Controller\ResourceControllerFactory::class,
            Controller\ResourceAPIController::class => Controller\ResourceAPIControllerFactory::class,            
            Controller\RoleResourceController::class => Controller\RoleResourceControllerFactory::class,
            Controller\RoleResourceAPIController::class => Controller\RoleResourceAPIControllerFactory::class,
            Controller\EmployeeRoleController::class => Controller\EmployeeRoleControllerFactory::class,
            Controller\EmployeeRoleAPIController::class => Controller\EmployeeRoleAPIControllerFactory::class,
            Controller\InventoryController::class => Controller\InventoryControllerFactory::class,
            Controller\InventoryAPIController::class => Controller\InventoryAPIControllerFactory::class
        ],
    ],
    'view_manager' => [
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
            'EmployeeTable' => Model\EmployeeTableFactory::class,
            'RoleTable' => Model\RoleTableFactory::class,
            'ResourceTable' => Model\ResourceTableFactory::class,
            'RoleResourceTable' => Model\RoleResourceTableFactory::class,
            'EmployeeRoleTable' => Model\EmployeeRoleTableFactory::class,
            'IdentityManager' => Model\IdentityManagerFactory::class
        ]
    ]    
];
