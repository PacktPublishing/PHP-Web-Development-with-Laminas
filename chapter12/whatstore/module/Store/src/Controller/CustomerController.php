<?php
declare(strict_types=1);

namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Store\Model\CustomerTable;
use Store\Model\Customer;
use Store\Form\CustomerForm;
use Store\Form\LoginForm;
use Laminas\Authentication\AuthenticationService;
use Laminas\Session\SessionManager;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\View\Model\JsonModel;
use Generic\Model\Identity;

class CustomerController extends AbstractActionController
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
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $this->adapter->setIdentity($email);
        $this->adapter->setCredential(Customer::encrypt($password));
        
        $logged = false;
        
        $auth = new AuthenticationService();
        $auth->setAdapter($this->adapter);
        
        $result = $auth->authenticate();
        
        if ($result->isValid()) {
            Identity::create(Customer::class);
            error_log('user ' . $result->getIdentity() . ' is logged');
            Customer::setCustomer($this->adapter->getResultRowObject(null,'password'));
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
    
    public function registerAction()
    {
        $form = new CustomerForm();
        return new ViewModel([
            'form' => $form
        ]);
    }
    
    public function logoutAction()
    {
        Identity::clear();
        
        return $this->redirect()->toRoute('store');
    }
}