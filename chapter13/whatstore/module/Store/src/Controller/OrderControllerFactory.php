<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class OrderControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $productBasket = $container->get('ProductBasket');
        $purchaseOrderTable = $container->get('PurchaseOrderTable');
        $orderItemTable = $container->get('OrderItemTable');
        return new OrderController($productBasket, $purchaseOrderTable, $orderItemTable);
    }
}