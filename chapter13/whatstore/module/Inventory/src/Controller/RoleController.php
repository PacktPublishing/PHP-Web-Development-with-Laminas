<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\RoleTable;
use Inventory\Form\RoleForm;

class RoleController extends AbstractActionController
{   
    private ?RoleTable $roleTable = null;
    
    public function __construct(RoleTable $roleTable)
    {
        $this->roleTable = $roleTable;
    }
    
    public function indexAction()
    {
        $roles = $this->roleTable->getAll();
        return new ViewModel(['roles' => $roles]);
    }
    
    public function editAction()
    {        
        $key = $this->params('key');
        $role = $this->roleTable->getByField('code',$key);
        $form = new RoleForm();
        $form->bind($role);
        return new ViewModel([
            'role' => $role,
            'form' => $form
        ]);
    }
}