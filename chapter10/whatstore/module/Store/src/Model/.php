<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;

class ProductTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'Inventory\Model\Product';

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}