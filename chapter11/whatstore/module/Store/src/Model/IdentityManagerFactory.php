<?php
declare(strict_types = 1);
namespace Store\Model;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IdentityManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = new CredentialTreatmentAdapter($container->get('DbAdapter'));
        $adapter->setTableName('customers');
        $adapter->setIdentityColumn('email');
        $adapter->setCredentialColumn('password');
        
        $encryptionMethod = array(new Customer(),'encrypt');
        
        return new IdentityManager($adapter, $encryptionMethod);
    }
}