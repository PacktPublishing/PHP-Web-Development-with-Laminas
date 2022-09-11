<?php
namespace Generic\Model;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Session\SessionManager;

class IdentityManager
{
    protected ?AdapterInterface $adapter;
    protected ?array $encryptionMethod;
    protected ?AuthenticationService $auth;
    
    public function __construct(AdapterInterface $adapter, array $encryptionMethod)
    {
        $this->adapter = $adapter;
        $this->encryptionMethod = $encryptionMethod;
        $this->auth = new AuthenticationService();
    }

    public function login(string $identity, string $credential): bool
    {
        $this->adapter->setIdentity($identity);
        $credential = call_user_func($this->encryptionMethod, $credential);
        $this->adapter->setCredential($credential);
        
        $this->auth->setAdapter($this->adapter);
        
        $result = $this->auth->authenticate();
        
        if ($result->isValid()) {
            error_log('user ' . $result->getIdentity() . ' is logged');
            $this->doCustomTasks();
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
    
    public function getIdentity()
    {
        return $this->auth->getIdentity();
    }
    
    public function hasIdentity(): bool
    {
        return $this->auth->hasIdentity();
    }
    
    protected function doCustomTasks(): void
    {        
    }    
}
