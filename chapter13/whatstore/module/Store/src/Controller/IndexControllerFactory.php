<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Store\Model\IdentityManager;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $productTable = $container->get('ProductTable');
        $identityManager = $container->get(IdentityManager::class);
        return new IndexController($productTable, $identityManager);
    }
}