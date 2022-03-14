<?php

declare(strict_types=1);

namespace School;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'schoolclass' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/schoolclass[/:action[/:code]]',
                    'defaults' => [
                        'controller' => 'schoolclass',
                        'action'     => 'index',
                    ],
                ],
            ],
            'student' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/student[/:action[/:id]]',
                    'defaults' => [
                        'controller' => 'student',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'schoolclass' => Controller\SchoolClassController::class,
            'student' => Controller\StudentController::class
        ],
        'factories' => [
            Controller\SchoolClassController::class => Controller\SchoolClassControllerFactory::class,
            Controller\StudentController::class => Controller\StudentControllerFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            'SchoolClassTable' => Model\SchoolClassTableFactory::class,
            'StudentTable' => Model\StudentTableFactory::class
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
