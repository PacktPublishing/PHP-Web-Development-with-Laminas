<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = new CredentialTreatmentAdapter($container->get('DbAdapter'));
        $adapter->setTableName('employees');
        $adapter->setIdentityColumn('nickname');
        $adapter->setCredentialColumn('password');
        
        $resourceTable = $container->get('ResourceTable');
        
        return new IndexController($adapter, $resourceTable);
    }
}