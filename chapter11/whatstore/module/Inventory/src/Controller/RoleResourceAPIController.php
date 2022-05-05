<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\RoleResource;
use Inventory\Model\RoleResourceTable;

class RoleResourceAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private RoleResourceTable $roleResourceTable;
    
    public function __construct(RoleResourceTable $roleResourceTable)
    {
        $this->roleResourceTable = $roleResourceTable;
    }
    
    public function create($data)
    {
        $roleResource = new RoleResource();
        $inputFilter = $roleResource->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $roleResource->exchangeArray($data);
        $inserted = $this->roleResourceTable->save($roleResource);
        return new JsonModel(['inserted' => $inserted]);
    }
            
    public function delete($id)
    {
        $deleted = $this->roleResourceTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}