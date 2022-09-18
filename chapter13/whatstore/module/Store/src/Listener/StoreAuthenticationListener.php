<?php
namespace Store\Listener;

use Laminas\Mvc\MvcEvent;
use Store\Model\IdentityManager;

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
        $identityManager = $event->getApplication()->getServiceManager()->get(IdentityManager::class);
        if (!$identityManager->hasIdentity()){
            $action = $params['action'];
            if ($controller == 'index' && ($action == 'index' || $action == 'login')){
                return;
            }
            $event->getRouteMatch()->setParam('controller', 'customer');
            $event->getRouteMatch()->setParam('action', 'index');
        }
    }
}
