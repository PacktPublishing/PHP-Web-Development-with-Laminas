<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class CustomerControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $customerTable = $container->get('CustomerTable');
        return new CustomerController($customerTable);
    }
}