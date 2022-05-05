<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Generic\Model\AbstractModel;
use Laminas\Db\Sql\Select;

class InventoryTable extends AbstractTable
{

    protected string $keyName = 'code_product';

    protected string $modelName = 'Inventory\Model\Inventory';
    
    public function addItems($codeProduct, int $amount): int
    {
        $inventory = $this->getByField('code_product', $codeProduct);
        $set = $inventory->toArray();
        $set['amount']+= $amount;
        return $this->tableGateway->update($set,['code_product' => $codeProduct]);
    }
    
    public function subtractItems($codeProduct, int $amount): int
    {
        $inventory = $this->getByField('code_product', $codeProduct);
        $set = $inventory->toArray();
        $set['amount']-= $amount;
        return $this->tableGateway->update($set,['code_product' => $codeProduct]);
    }
    
    public function reserveItems($codeProduct, int $amount): int
    {
        $inventory = $this->getByField('code_product', $codeProduct);
        $set = ['reserved' => $amount];
        return $this->tableGateway->update($set,['code_product' => $codeProduct]);
    }
    
    public function setMaximum($codeProduct, int $amount): int
    {
        $inventory = $this->getByField('code_product', $codeProduct);
        $set = ['maximum' => $amount];
        return $this->tableGateway->update($set,['code_product' => $codeProduct]);
    }
    
    public function setMinimum($codeProduct, int $amount): int
    {
        $inventory = $this->getByField('code_product', $codeProduct);
        $set = ['minimum' => $amount];
        return $this->tableGateway->update($set,['code_product' => $codeProduct]);
    }
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $keyName = $this->keyName;
        $inventory = $this->getByField($keyName,$set[$keyName]);
        try {
            if (empty($inventory->product->code)) {
                $this->tableGateway->insert($set);
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
    
    public function getAll($where = null): iterable
    {
        $select = new Select($this->tableGateway->getTable());
        $select->join('products','inventory.code_product=products.code',['product' => 'name']);
        if (!is_null($where)){
            $select->where($where);
        }
        return $this->tableGateway->selectWith($select);
    }
}