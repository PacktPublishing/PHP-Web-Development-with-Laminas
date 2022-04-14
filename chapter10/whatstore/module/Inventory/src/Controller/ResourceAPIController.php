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
    
    public function get($id)
    {
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $resource = $this->resourceTable->getByField($field, $id);
        return new JsonModel(['resource' => $resource->toArray()]);
    }
    
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
    
    public function delete($id)
    {
        $deleted = $this->resourceTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}