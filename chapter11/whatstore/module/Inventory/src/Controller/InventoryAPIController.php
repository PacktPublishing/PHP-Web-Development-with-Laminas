<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\Inventory;
use Inventory\Model\InventoryTable;

class InventoryAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private InventoryTable $inventoryTable;
    
    public function __construct(InventoryTable $inventoryTable)
    {
        $this->inventoryTable = $inventoryTable;
    }
    
    public function get($id)
    {
        $field = 'code_product';
        $id = (int) $id;
        $inventory = $this->inventoryTable->getByField($field, $id);
        return new JsonModel(['inventory' => $inventory->toFullArray()]);
    }
    
    public function update($id, $data)
    {
        $inventory = $this->inventoryTable->getByField('code', $id);
        $operation = $data['operation'];
        $methods = [
            'add' => 'addItems',
            'remove' => 'subtractItems',
            'reserve' => 'reserveItems',
            'maximum' => 'setMaximum',
            'minimum' => 'setMinimum'            
        ];
        $method = ($methods[$operation] ?? 'invalid');
        if ($method == 'invalid'){
            $updated = false;
        } else {
            $updated = $this->inventoryTable->$method($id,$data['amount']);
        }
        $updated = (bool) $updated;
        return new JsonModel(['updated' => $updated]);
    }
}