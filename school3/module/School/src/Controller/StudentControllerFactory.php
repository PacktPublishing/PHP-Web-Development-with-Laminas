<?php
namespace School\Controller;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class StudentControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $studentTable = $container->get('StudentTable');
        $schoolClassTable = $container->get('SchoolClassTable');
        return new StudentController($studentTable, $schoolClassTable);
    }
}