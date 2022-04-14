<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Laminas\Db\Sql\Select;

class ProductTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'Inventory\Model\Product';
    
    public function getAll($where = null): iterable {
        $select = new Select($this->tableGateway->getTable());
        $select->join('discounts','products.code_discount=discounts.code',['name_discount' => 'name']);
        if (!is_null($where)){
            $parsedWhere = [];
            foreach($where as $index => $value){
                $parsedWhere['products.' . $index] = $value;
            }
            $select->where($parsedWhere);
        }
        return $this->tableGateway->selectWith($select);        
    }
    
}