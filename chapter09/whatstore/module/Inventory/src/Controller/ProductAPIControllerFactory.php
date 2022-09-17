<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ProductAPIControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $productTable = $container->get('ProductTable');
        return new ProductAPIController($productTable);
    }
}