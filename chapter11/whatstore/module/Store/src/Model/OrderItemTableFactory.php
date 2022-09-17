<?php
declare(strict_types = 1);
namespace Store\Model;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class OrderItemTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Customer());
        $tableGateway = new TableGateway('order_items', $adapter, null, $resultSetPrototype);
        return new OrderItemTable($tableGateway);
    }
}