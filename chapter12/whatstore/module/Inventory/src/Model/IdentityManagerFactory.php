<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;

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
        
        $encryptionMethod = array(new Employee(),'encrypt');
        
        return new IdentityManager($adapter, $resourceTable, $encryptionMethod);
    }
}