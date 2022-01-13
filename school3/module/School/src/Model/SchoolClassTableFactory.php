<?php
declare(strict_types = 1);
namespace School\Model;

use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SchoolClassTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new SchoolClass());
        $tableGateway = new TableGateway('classes', $adapter, null, $resultSetPrototype);
        return new SchoolClassTable($tableGateway);
    }
}