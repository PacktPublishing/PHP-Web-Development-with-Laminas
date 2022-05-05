<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Laminas\Db\Sql\Select;
use Generic\Model\AbstractModel;
use Laminas\Db\Sql\Expression;

class ProductTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'Inventory\Model\Product';
    
    private ?InventoryTable $inventoryTable;
    
    public function setInventoryTable(InventoryTable $inventoryTable): void
    {
        $this->inventoryTable = $inventoryTable; 
    }
    
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
    
    public function getAllDiscounted($where = null): iterable {
        $expression = <<<EXPRESSION
(CASE 
WHEN discounts.operator = '-' THEN products.price - discounts.factor 
WHEN discounts.operator = '*' THEN products.price * discounts.factor 
WHEN discounts.operator = '/' THEN products.price / discounts.factor 
END)'
EXPRESSION;
        
        $select = new Select($this->tableGateway->getTable());
        $select->join('discounts','products.code_discount=discounts.code',
            [new Expression($expression) => 'discountedprice']);
        if (!is_null($where)){
            $parsedWhere = [];
            foreach($where as $index => $value){
                $parsedWhere['products.' . $index] = $value;
            }
            $select->where($parsedWhere);
        }
        return $this->tableGateway->selectWith($select);
    }
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $keyName = $this->keyName;
        try {
            if (empty($model->$keyName)) {
                unset($set[$keyName]);
                $this->tableGateway->insert($set);
                $lastCode = $this->tableGateway->getLastInsertValue();
                $inventory = new Inventory();
                $inventory->exchangeArray(['code_product' => $lastCode]);
                $this->inventoryTable->save($inventory);                
            } else {
                $this->tableGateway->update($set, [
                    $keyName => $set[$keyName]
                ]);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
    public function delete($value): bool
    {
        try {
            $this->inventoryTable->delete([
                'code_product' => $value
            ]);
            $this->tableGateway->delete([
                $this->keyName => $value
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
}