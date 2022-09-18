<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class EmployeeTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Employee());
        $tableGateway = new TableGateway('employees', $adapter, null, $resultSetPrototype);
        return new EmployeeTable($tableGateway);
    }
}