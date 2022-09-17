<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class CustomerAPIControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $customerTable = $container->get('CustomerTable');
        return new CustomerAPIController($customerTable);
    }
}