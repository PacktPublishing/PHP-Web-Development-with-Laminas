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

class IndexController extends AbstractActionController
{
    private ?AdapterInterface $adapter;
    
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;        
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
            error_log('user ' . $result->getIdentity() . ' is logged');
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
        $auth = new AuthenticationService();
        $auth->clearIdentity();
        
        return $this->redirect()->toRoute('inventory');
    }
}
