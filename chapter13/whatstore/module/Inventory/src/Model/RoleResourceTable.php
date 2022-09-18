<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Generic\Model\AbstractModel;
use Laminas\Db\Sql\Select;

class RoleResourceTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'Inventory\Model\RoleResource';
    
    public function getAll($where = null): iterable
    {
        $select = new Select($this->tableGateway->getTable());
        $select->join('resources','resources_role.code_resource=resources.code',['resource' => 'name'])
        ->join('roles','resources_role.code_role=roles.code',['role' => 'name'])
        ->order(['roles.name','resources.name']);
        if (!is_null($where)){
            $select->where($where);
        }
        return $this->tableGateway->selectWith($select);
    }    
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $resourcesRole = $this->getByFields([
            'code_resource' => $model->resource->code,
            'code_role'=> $model->role->code,
        ]);
        try {
            if (empty($resourcesRole->code)) {
                $this->tableGateway->insert($set);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
    
    
    
    
}