<?php
namespace Inventory\Listener;

use Laminas\Mvc\MvcEvent;
use Generic\Model\Identity;
use Inventory\Model\Employee;

class InventoryAuthenticationListener
{
    public static function verifyIdentity(MvcEvent $event)
    {
        $routeName = $event->getRouteMatch()->getMatchedRouteName();
        if ($routeName !== 'inventory'){
            return;
        }
        if (!Identity::has(Employee::class)){
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