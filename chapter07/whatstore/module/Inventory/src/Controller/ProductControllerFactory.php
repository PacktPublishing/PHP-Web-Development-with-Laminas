<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ProductControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $producTable = $container->get('ProductTable');
        $discountTable = $container->get('DiscountTable');
        return new ProductController($producTable, $discountTable);
    }
}