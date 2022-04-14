<?php
declare(strict_types = 1);
namespace Generic\Model;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

abstract class AbstractTable
{

    protected TableGatewayInterface $tableGateway;

    protected string $keyName;

    protected string $modelName;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }    

    public function getByField(string $field, $value): AbstractModel
    {
        $where = [
            $field => $value
        ];
        $rowSet = $this->getAll($where);
        if ($rowSet->count() == 0) {
            $modelName = $this->modelName;
            return new $modelName();
        }
        return $rowSet->current();
    }
    
    public function getByFields(array $fields): AbstractModel
    {
        $where = [];
        foreach($fields as $field => $value){
            $where[$field] = $value;
        }
        $rowSet = $this->getAll($where);
        if ($rowSet->count() == 0) {
            $modelName = $this->modelName;
            return new $modelName();
        }
        return $rowSet->current();
    }

    public function getAll($where = null): iterable
    {
        $select = new Select($this->tableGateway->getTable());
        if (!is_null($where)){
            $select->where($where);
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