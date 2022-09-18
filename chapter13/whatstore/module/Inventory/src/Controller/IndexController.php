<?php

declare(strict_types=1);

namespace Inventory\Controller;

use Inventory\Form\LoginForm;
use Inventory\Model\IdentityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
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
        $nickname = $this->request->getPost('nickname');
        $password = $this->request->getPost('password');
        
        $logged = $this->identityManager->login($nickname, $password);        
        
        return new JsonModel([
            'logged' => $logged
        ]);
    }
    
    public function logoutAction()
    {
        $this->identityManager->logout();
        
        return $this->redirect()->toRoute('inventory');
    }    
}
