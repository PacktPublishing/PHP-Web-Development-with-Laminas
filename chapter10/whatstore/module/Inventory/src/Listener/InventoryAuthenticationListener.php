<?php
namespace Inventory\Listener;

use Laminas\Mvc\MvcEvent;
use Laminas\Authentication\AuthenticationService;
use Laminas\Http\PhpEnvironment\Request;

class InventoryAuthenticationListener
{
    public static function verifyIdentity(MvcEvent $event)
    {
        $routeName = $event->getRouteMatch()->getMatchedRouteName();
        if (!$routeName == 'inventory'){
            return;
        }
        $authenticationService = new AuthenticationService();
        if (!$authenticationService->hasIdentity()){
            $params = $event->getRouteMatch()->getParams();
            $controller = $params['controller'];
            $action = $params['action'];
            if ($controller == 'index' && ($action == 'index' || $action == 'login')){
                return;
            }
            $event->getRouteMatch()->setParam('controller', 'index');
            $event->getRouteMatch()->setParam('action', 'index');
        }
    }
}