<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\InventoryTable;
use Inventory\Form\InventoryForm;

class InventoryController extends AbstractActionController
{   
    private ?InventoryTable $inventoryTable = null;    
    
    public function __construct(InventoryTable $inventoryTable)
    {
        $this->inventoryTable = $inventoryTable;        
    }
    
    public function indexAction()
    {
        $inventories = $this->inventoryTable->getAll();
        return new ViewModel(['inventories' => $inventories]);
    }
    
    public function editAction()
    {        
        $key = $this->params('key');
        $inventory = $this->inventoryTable->getByField('code',$key);
        $form = new InventoryForm();
        $form->bind($inventory);
        $form->get('amount')->setValue(0);
        return new ViewModel([
            'form' => $form
        ]);
    }
}