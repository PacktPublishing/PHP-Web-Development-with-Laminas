<?php
declare(strict_types = 1);
namespace School;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;

class SchoolClassTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'School\SchoolClass';

    private static ?SchoolClassTable $instance = null;

    private function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public static function getInstance(): SchoolClassTable
    {
        if (null == self::$instance) {
            $adapter = self::getAdapter();
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new SchoolClass());
            $tableGateway = new TableGateway('classes', $adapter, null, $resultSetPrototype);
            self::$instance = new SchoolClassTable($tableGateway);
        }
        return self::$instance;
    }
}