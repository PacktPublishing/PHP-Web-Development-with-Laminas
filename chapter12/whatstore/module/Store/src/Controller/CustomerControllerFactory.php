<?php
namespace Store\Controller;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class CustomerControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = new CredentialTreatmentAdapter($container->get('DbAdapter'));
        $adapter->setTableName('customers');
        $adapter->setIdentityColumn('email');
        $adapter->setCredentialColumn('password');
        
        return new CustomerController($adapter);
    }
}