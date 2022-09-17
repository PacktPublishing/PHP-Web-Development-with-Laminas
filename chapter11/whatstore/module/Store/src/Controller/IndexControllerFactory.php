<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $productTable = $container->get('ProductTable');
        return new IndexController($productTable);
    }
}