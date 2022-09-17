<?php
namespace Inventory\Controller;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $employeeTable = $container->get('EmployeeTable');
        $adapter = new CredentialTreatmentAdapter($container->get('DbAdapter'));
        $adapter->setTableName('employees');
        $adapter->setIdentityColumn('nickname');
        $adapter->setCredentialColumn('password');
        
        return new IndexController($adapter);
    }
}