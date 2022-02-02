<?php
declare(strict_types = 1);
namespace School\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;

class SchoolClassTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'School\Model\SchoolClass';

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}