<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ProductTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Product());
        $tableGateway = new TableGateway('products', $adapter, null, $resultSetPrototype);
        return new ProductTable($tableGateway);
    }
}