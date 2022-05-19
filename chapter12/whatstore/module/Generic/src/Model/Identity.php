<?php
namespace Generic\Model;

use Laminas\Authentication\AuthenticationService;
use Laminas\Session\SessionManager;
use Laminas\Session\Container;

class Identity
{    
    public static function create(string $context): void
    {
        $container = new Container();
        $container->context = $context;
    }
    
    public static function has(string $context): bool
    {
        $auth = new AuthenticationService();
        $container = new Container();
        error_log("Context: " . $container->context);
        return ($auth->hasIdentity() && $container->context == $context);
    }
    
    public static function clear(): void
    {
        $auth = new AuthenticationService();
        $auth->clearIdentity();
        $container = new Container();
        unset($container->context);
        $session = new SessionManager();
        try {
            $session->destroy();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }
}

