<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;

class EmployeeRoleTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new EmployeeRole());
        $tableGateway = new TableGateway('employee_roles', $adapter, null, $resultSetPrototype);
        return new EmployeeRoleTable($tableGateway);
    }
}