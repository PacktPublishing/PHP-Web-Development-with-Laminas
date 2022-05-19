<?php

declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Form\LoginForm;
use Laminas\View\Model\JsonModel;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Adapter\AdapterInterface;
use Inventory\Model\Employee;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Session\Container;
use Laminas\Permissions\Rbac\Role;
use Inventory\Model\ResourceTable;
use Laminas\Session\SessionManager;
use Generic\Model\Identity;

class IndexController extends AbstractActionController
{
    private ?AdapterInterface $adapter;
    private ?ResourceTable $resourceTable;
    
    public function __construct(AdapterInterface $adapter, ResourceTable $resourceTable)
    {
        $this->adapter = $adapter;
        $this->resourceTable = $resourceTable;
    }
    
    public function indexAction()
    {
        $form = new LoginForm();
        return new ViewModel([
            'form' => $form
        ]);
    }
    
    public function loginAction()
    { 
        $nickname = $this->request->getPost('nickname');
        $password = $this->request->getPost('password');
        $this->adapter->setIdentity($nickname);
        $this->adapter->setCredential(Employee::encrypt($password)); 
        
        $logged = false;
        
        $auth = new AuthenticationService();
        $auth->setAdapter($this->adapter);
        
        $result = $auth->authenticate();
        
        if ($result->isValid()) {
            Identity::create(Employee::class);
            error_log('user ' . $result->getIdentity() . ' is logged');
            $this->loadAuthorizationData($result->getIdentity());
            $logged = true;
        } else {
            foreach ($result->getMessages() as $message) {
                error_log($message);
            }            
        }
        
        return new JsonModel([
            'logged' => $logged
        ]);
    }
    
    public function logoutAction()
    {
        Identity::clear();
        
        return $this->redirect()->toRoute('inventory');
    }
    
    private function loadAuthorizationData(string $identity): void
    {
        $role = new Role($identity);
        
        $row = $this->adapter->getResultRowObject();
        $resources = $this->resourceTable->getResourcesFromAnEmployee($row->ID);
        foreach($resources as $resource){
            $role->addPermission($resource->name . ':' . $resource->method);
        }
        $rbac = new Rbac();
        $rbac->addRole($role);
        
        $container = new Container();
        $container->rbac = $rbac;
    }
}
