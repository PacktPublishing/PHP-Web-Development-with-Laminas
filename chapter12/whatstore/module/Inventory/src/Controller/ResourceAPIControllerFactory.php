<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ResourceAPIControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $resourceTable = $container->get('ResourceTable');
        return new ResourceAPIController($resourceTable);
    }
}