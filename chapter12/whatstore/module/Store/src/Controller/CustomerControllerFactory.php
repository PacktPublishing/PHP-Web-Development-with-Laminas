<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Store\Model\IdentityManager;

class CustomerControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $identityManager = $container->get(IdentityManager::class);
        
        return new CustomerController($identityManager);
    }
}