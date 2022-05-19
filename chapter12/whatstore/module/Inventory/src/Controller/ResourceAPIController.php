<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\Resource;
use Inventory\Model\ResourceTable;

class ResourceAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private ResourceTable $resourceTable;
    
    public function __construct(ResourceTable $resourceTable)
    {
        $this->resourceTable = $resourceTable;
    }
    
    /**
     * @OA\Post(
     *     path="/inventoryapi/resourceapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="resource code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="method",type="string"),
     *             required={"name","method"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert a resource"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {
        $resource = new Resource();
        $inputFilter = $resource->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $resource->exchangeArray($data);
        $inserted = $this->resourceTable->save($resource);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/resourceapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="resource code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="get a resource"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function get($id)
    {
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $resource = $this->resourceTable->getByField($field, $id);
        return new JsonModel(['resource' => $resource->toArray()]);
    }
    
    /**
     * @OA\Put(
     *     path="/inventoryapi/resourceapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="resource code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="method",type="string"),
     *             required={"name","method"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="update a resource"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function update($id, $data)
    {
        $resource = $this->resourceTable->getByField('code', $id);
        $inputFilter = $resource->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            error_log(print_r($inputFilter->getMessages(),true));
            return new JsonModel(['updated' => 'invalid']);
        }
        $resource->exchangeArray($data);
        $updated = $this->resourceTable->save($resource);
        return new JsonModel(['updated' => $updated]);
    }
    
    /**
     * @OA\Delete(
     *     path="/inventoryapi/resourceapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="resource code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="remove a resource"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function delete($id)
    {
        $deleted = $this->resourceTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/resourceapi",
     *     @OA\Response(response="200", description="get list of resources"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function getList()
    {
        $resultSet = $this->resourceTable->getAll();
        $resources = [];
        foreach($resultSet as $result){
            $resources[] = $result->toArray();
        }
        return new JsonModel(['resources' => $resources]);
    }
}