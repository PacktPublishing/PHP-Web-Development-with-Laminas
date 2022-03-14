<?php
namespace School\Controller;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SchoolClassControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $schoolClassTable = $container->get('SchoolClassTable');
        return new SchoolClassController($schoolClassTable);
    }
}