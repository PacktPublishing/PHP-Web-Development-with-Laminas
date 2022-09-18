<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Generic\Filter\Encrypt;

class IdentityManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $employeeTable = $container->get('EmployeeTable');
        $adapter = new CredentialTreatmentAdapter($container->get('DbAdapter'));
        $adapter->setTableName('employees');
        $adapter->setIdentityColumn('nickname');
        $adapter->setCredentialColumn('password');
        
        $resourceTable = $container->get('ResourceTable');
        
        $encryptionMethod = array(new Encrypt(),'filter');
        
        return new IdentityManager($adapter, $resourceTable, $encryptionMethod);
    }
}