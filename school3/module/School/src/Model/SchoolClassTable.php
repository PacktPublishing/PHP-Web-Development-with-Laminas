<?php
declare(strict_types = 1);
namespace School\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;

class SchoolClassTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'School\Model\SchoolClass';

    private static ?SchoolClassTable $instance = null;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}