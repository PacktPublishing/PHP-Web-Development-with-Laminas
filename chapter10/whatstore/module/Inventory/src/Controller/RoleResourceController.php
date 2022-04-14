<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\RoleResourceTable;
use Inventory\Model\ResourceTable;
use Inventory\Model\RoleTable;
use Inventory\Form\RoleResourceForm;

class RoleResourceController extends AbstractActionController
{   
    private ?RoleResourceTable $roleResourceTable = null;
    private ?ResourceTable $resourceTable = null;
    private ?RoleTable $roleTable = null;
    
    public function __construct(RoleResourceTable $roleResourceTable, ResourceTable $resourceTable, RoleTable $roleTable)
    {
        $this->roleResourceTable = $roleResourceTable;
        $this->resourceTable = $resourceTable;
        $this->roleTable = $roleTable;
    }
    
    public function indexAction()
    {
        $roleResources = $this->roleResourceTable->getAll();
        return new ViewModel(['roleResources' => $roleResources]);
    }
    
    public function editAction()
    {        
        $form = new RoleResourceForm();
        $resources = [];
        $rows = $this->resourceTable->getAll();
        foreach($rows as $row){
            $resources[$row->code] = $row->name;
        }
        $roles = [];
        $rows = $this->roleTable->getAll();
        foreach($rows as $row){
            $roles[$row->code] = $row->name;
        }
        $form->get('code_resource')->setValueOptions($resources);
        $form->get('code_role')->setValueOptions($roles);
        return new ViewModel([
            'form' => $form
        ]);
    }
}