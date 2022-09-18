<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Generic\Model\AbstractModel;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Expression;
use Laminas\Db\Sql\Where;

class ResourceTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'Inventory\Model\Resource';
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $keyName = $this->keyName;
        $resource = $this->getByField('code', $model->$keyName);
        try {
            if (empty($resource->$keyName)) {
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
    
    public function getResourcesFromAnEmployee($employeeID): ResultSet
    {
        $subSelect = new Select('employee_roles');
        $subSelect->columns(['code_role'])
        ->where(['ID_employee' => $employeeID]);
        
        $where = new Where();
        $where->in('resources_role.code_role', $subSelect);        
        
        $select = new Select($this->tableGateway->getTable());
        $select->columns(['name' => new Expression('DISTINCT name'),'method'])
        ->join('resources_role', 'resources.code = resources_role.code_resource',[])
        ->where($where);
        
        return $this->tableGateway->selectWith($select);
    }
}