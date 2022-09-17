<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class OrderAPIControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $productBasket = $container->get('ProductBasket');
        $purchaseOrderTable = $container->get('PurchaseOrderTable');
        $orderItemTable = $container->get('OrderItemTable');        
        return new OrderAPIController($productBasket, $purchaseOrderTable, $orderItemTable);
    }
}