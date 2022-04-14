<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RoleResourceControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roleResourceTable = $container->get('RoleResourceTable');
        $resourceTable = $container->get('ResourceTable');
        $roleTable = $container->get('RoleTable');
        return new RoleResourceController($roleResourceTable,$resourceTable,$roleTable);
    }
}