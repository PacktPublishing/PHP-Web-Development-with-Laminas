<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class EmployeeRoleAPIControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $employeeRoleTable = $container->get('EmployeeRoleTable');
        return new EmployeeRoleAPIController($employeeRoleTable);
    }
}