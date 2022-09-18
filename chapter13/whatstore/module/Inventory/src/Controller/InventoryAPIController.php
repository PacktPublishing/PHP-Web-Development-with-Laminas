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
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/inventoryapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="product code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="get an inventory"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function get($id)
    {
        $field = 'code_product';
        $id = (int) $id;
        $inventory = $this->inventoryTable->getByField($field, $id);
        return new JsonModel(['inventory' => $inventory->toFullArray()]);
    }
    
    /**
     * @OA\Put(
     *     path="/inventoryapi/inventoryapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="product code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code_product",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="operation",type="string"),
     *             @OA\Property(property="amount",type="integer"),
     *             required={"name","nickname","password"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="update an inventory"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
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