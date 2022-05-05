<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\Role;
use Inventory\Model\RoleTable;

class RoleAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private RoleTable $roleTable;
    
    public function __construct(RoleTable $roleTable)
    {
        $this->roleTable = $roleTable;
    }
    
    public function create($data)
    {
        $role = new Role();
        $inputFilter = $role->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $role->exchangeArray($data);
        $inserted = $this->roleTable->save($role);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    public function get($id)
    {
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $role = $this->roleTable->getByField($field, $id);
        return new JsonModel(['role' => $role->toArray()]);
    }
    
    public function update($id, $data)
    {
        $role = $this->roleTable->getByField('code', $id);
        $inputFilter = $role->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            error_log(print_r($inputFilter->getMessages(),true));
            return new JsonModel(['updated' => 'invalid']);
        }
        $role->exchangeArray($data);
        $updated = $this->roleTable->save($role);
        return new JsonModel(['updated' => $updated]);
    }
    
    public function delete($id)
    {
        $deleted = $this->roleTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}