<?php

declare(strict_types=1);

namespace Store;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
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
            'customerapi' => Controller\CustomerAPIController::class
        ],
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\CustomerController::class => Controller\CustomerControllerFactory::class,
            Controller\CustomerAPIController::class => Controller\CustomerAPIControllerFactory::class
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
            'application/index/index' => __DIR__ . '/../view/store/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'CustomerTable' => Model\CustomerTableFactory::class
        ]
    ],
    'view_helpers' => [
        'aliases' => [
            'form' => Form::class,
            'formText' => FormText::class,
            'formSelect' => FormSelect::class,
            'formNumber' => FormNumber::class,
            'formHidden' => FormHidden::class,
            'formLabel' => FormLabel::class,
            'formPassword' => FormPassword::class,
        ],
        'factories' => [
            Form::class => InvokableFactory::class,
            FormText::class => InvokableFactory::class,
            FormSelect::class => InvokableFactory::class,
            FormNumber::class => InvokableFactory::class,
            FormHidden::class => InvokableFactory::class,
            FormLabel::class => InvokableFactory::class,
            FormPassword::class => InvokableFactory::class
        ]
    ]    
];
