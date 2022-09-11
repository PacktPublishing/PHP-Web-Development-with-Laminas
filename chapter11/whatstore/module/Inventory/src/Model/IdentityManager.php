<?php
namespace Inventory\Model;

use Generic\Model\IdentityManager as GenericIdentityManager;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role;
use Laminas\Session\Container;

class IdentityManager extends GenericIdentityManager
{
    private ?ResourceTable $resourceTable;
    
    public function setResourceTable(ResourceTable $resourceTable)
    {
        $this->resourceTable = $resourceTable;
    }

    protected function doCustomTasks(): void
    {
        $this->auth->getStorage()->write($this->adapter->getResultRowObject(null,'password'));
        $this->loadAuthorizationData();        
    }
    
    private function loadAuthorizationData(): void
    {
        $role = new Role($this->auth->getIdentity()->name);
        
        $row = $this->auth->getStorage()->read();
        $resources = $this->resourceTable->getResourcesFromAnEmployee($row->ID);
        foreach($resources as $resource){
            $role->addPermission($resource->name . ':' . $resource->method);
        }
        $rbac = new Rbac();
        $rbac->addRole($role);
        
        $container = new Container();
        if (isset($container->rbac)){
            unset($container->rbac);
        }
        $container->rbac = $rbac;
    }    
    
    public function getRbac(): Rbac
    {
        $this->loadAuthorizationData();
        $container = new Container();
        return $container->rbac;
    }
}
