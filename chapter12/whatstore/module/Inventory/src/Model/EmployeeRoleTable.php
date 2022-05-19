<?php
declare(strict_types = 1);
namespace Inventory\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Generic\Model\AbstractModel;
use Laminas\Db\Sql\Select;

class EmployeeRoleTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'Inventory\Model\EmployeeRole';
    
    public function getAll($where = null): iterable
    {
        $select = new Select($this->tableGateway->getTable());
        $select->join('roles','employee_roles.code_role=roles.code',['role' => 'name'])
        ->join('employees','employee_roles.ID_employee=employees.ID',['employee' => 'name'])
        ->order(['employees.name','roles.name']);
        if (!is_null($where)){
            $select->where($where);
        }
        return $this->tableGateway->selectWith($select);
    }
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $employeeRole = $this->getByFields([
            'code_role'=> $model->role->code,
            'ID_employee' => $model->employee->ID            
        ]);
        try {
            if (empty($employeeRole->code)) {
                $this->tableGateway->insert($set);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
}