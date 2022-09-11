<?php
declare(strict_types=1);

namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Store\Form\CustomerForm;
use Store\Form\LoginForm;
use Store\Model\IdentityManager;

class CustomerController extends AbstractActionController
{   
    private ?IdentityManager $identityManager;
    
    public function __construct(IdentityManager $identityManager)
    {
        $this->identityManager = $identityManager;
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
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $logged = $this->identityManager->login($email, $password);        
        
        return new JsonModel([
            'logged' => $logged
        ]);
    }
    
    public function registerAction()
    {
        $form = new CustomerForm();
        return new ViewModel([
            'form' => $form
        ]);
    }
    
    public function logoutAction()
    {
        $this->identityManager->logout();
        
        return $this->redirect()->toRoute('store');
    }
}