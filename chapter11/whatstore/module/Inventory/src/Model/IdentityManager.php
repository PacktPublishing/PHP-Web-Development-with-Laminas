<?php
namespace Inventory\Model;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Session\SessionManager;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Session\Container;
use Laminas\Permissions\Rbac\Role;

class IdentityManager
{
    private ?AdapterInterface $adapter;
    private ?ResourceTable $resourceTable;
    private ?array $encryptionMethod;
    private ?AuthenticationService $auth;
    
    public function __construct(AdapterInterface $adapter, ResourceTable $resourceTable, array $encryptionMethod)
    {
        $this->adapter = $adapter;
        $this->resourceTable = $resourceTable;
        $this->encryptionMethod = $encryptionMethod;
        $this->auth = new AuthenticationService();
    }

    public function login(string $identity, string $credential): bool
    {
        $this->adapter->setIdentity($identity);
        $credential = call_user_func($this->encryptionMethod, $credential);
        $this->adapter->setCredential($credential);
        
        $logged = false;
        
        $this->auth->setAdapter($this->adapter);
        
        $result = $this->auth->authenticate();
        
        if ($result->isValid()) {
            error_log('user ' . $result->getIdentity() . ' is logged');
            $this->auth->getStorage()->write($this->adapter->getResultRowObject(null,'password'));
            $this->loadAuthorizationData();
            return true;
        } else {
            foreach ($result->getMessages() as $message) {
                error_log($message);
            }
        }
        return false;
    }
    
    public function logout(): void
    {
        $this->auth->clearIdentity();
        $session = new SessionManager();
        try {
            $session->destroy();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }        
    }
    
    public function loadAuthorizationData(): void
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
    
    public function getIdentity(): string
    {
        return $this->auth->getIdentity()->name;
    }
    
    public function hasIdentity(): bool
    {
        return $this->auth->hasIdentity();
    }
    
    public function getRbac(): Rbac
    {
        $this->loadAuthorizationData();
        $container = new Container();
        return $container->rbac;
    }
}
