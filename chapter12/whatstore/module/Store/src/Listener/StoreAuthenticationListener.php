<?php
namespace Store\Listener;

use Laminas\Mvc\MvcEvent;
use Generic\Model\Identity;
use Store\Model\Customer;

class StoreAuthenticationListener
{
    public static function verifyIdentity(MvcEvent $event)
    {
        $routeName = $event->getRouteMatch()->getMatchedRouteName();
        if ($routeName !== 'store'){
            return;
        }
        $params = $event->getRouteMatch()->getParams();
        $controller = $params['controller'];
        if ($controller !== 'order'){
            return;
        }
        if (!Identity::has(Customer::class)){
            $action = $params['action'];
            if ($controller == 'index' && ($action == 'index' || $action == 'login')){
                return;
            }
            $event->getRouteMatch()->setParam('controller', 'customer');
            $event->getRouteMatch()->setParam('action', 'index');
        }
    }
}
