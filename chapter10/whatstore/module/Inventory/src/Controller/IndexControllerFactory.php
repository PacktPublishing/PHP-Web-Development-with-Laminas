<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $identityManager = $container->get('IdentityManager');
        
        return new IndexController($identityManager);
    }
}