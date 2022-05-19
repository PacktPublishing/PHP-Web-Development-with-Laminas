<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\ResourceTable;
use Inventory\Form\ResourceForm;

class ResourceController extends AbstractActionController
{   
    private ?ResourceTable $resourceTable = null;
    
    public function __construct(ResourceTable $resourceTable)
    {
        $this->resourceTable = $resourceTable;
    }
    
    public function indexAction()
    {
        $resources = $this->resourceTable->getAll();
        return new ViewModel(['resources' => $resources]);
    }
    
    public function editAction()
    {        
        $key = $this->params('key');
        $resource = $this->resourceTable->getByField('code',$key);
        $form = new ResourceForm();
        $form->bind($resource);
        return new ViewModel([
            'resource' => $resource,
            'form' => $form
        ]);
    }
}