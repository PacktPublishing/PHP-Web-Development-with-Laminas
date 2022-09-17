<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RoleResourceAPIControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roleResourceTable = $container->get('RoleResourceTable');
        return new RoleResourceAPIController($roleResourceTable);
    }
}