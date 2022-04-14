<?php
namespace Inventory\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Authentication\AuthenticationService;

class MenuController extends AbstractActionController
{
    public function indexAction()
    {
        $auth = new AuthenticationService();
        return new ViewModel(['user' => $auth->getIdentity()]);
    }
    
    public function noPermissionAction()
    {
        $auth = new AuthenticationService();
        return new ViewModel(['user' => $auth->getIdentity()]);
    }
}