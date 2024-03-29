<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IdentityManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = new CredentialTreatmentAdapter($container->get('DbAdapter'));
        $adapter->setTableName('employees');
        $adapter->setIdentityColumn('nickname');
        $adapter->setCredentialColumn('password');
        
        $resourceTable = $container->get('ResourceTable');
        
        $encryptionMethod = array(new Employee(),'encrypt');
        
        $identityManager = new IdentityManager($adapter, $encryptionMethod);
        $identityManager->setResourceTable($resourceTable);
        return $identityManager;
    }
}