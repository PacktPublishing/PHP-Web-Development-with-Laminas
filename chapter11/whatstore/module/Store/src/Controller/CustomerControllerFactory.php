<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;

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