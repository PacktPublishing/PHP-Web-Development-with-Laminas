<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ProductTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Product());
        $tableGateway = new TableGateway('products', $adapter, null, $resultSetPrototype);
        $productTable = new ProductTable($tableGateway);
        $inventoryTable = $container->get('InventoryTable');
        $productTable->setInventoryTable($inventoryTable);
        return $productTable;
    }
}