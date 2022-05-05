<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class EmployeeRoleControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $employeeRoleTable = $container->get('EmployeeRoleTable');
        $employeeTable = $container->get('EmployeeTable');
        $roleTable = $container->get('RoleTable');
        return new EmployeeRoleController($employeeRoleTable,$employeeTable,$roleTable);
    }
}