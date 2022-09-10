<?php
namespace Inventory\Listener;

use Laminas\Mvc\MvcEvent;

class InventoryAuthorizationListener
{
    public static function verifyPermission(MvcEvent $event)
    {
        $routeName = $event->getRouteMatch()->getMatchedRouteName();
        if ($routeName !== 'inventory'){
            return;
        }
        $identityManager = $event->getApplication()->getServiceManager()->get('IdentityManager');
        if ($identityManager->hasIdentity()){
            $params = $event->getRouteMatch()->getParams();
            $controller = $params['controller'];
            $action = $params['action'] ?? 'rest';            
            
            if ($controller == 'menu' || $action == 'logout'){
                return;
            }
            
            $method = $event->getRequest()->getMethod();
            $action = ($action == 'rest' ? $method : $action);
            $action = ($action == 'POST' ? 'create' : $action);
            $action = ($action == 'PUT' ? 'update': $action);
            $permission = $controller . '.' . $action . ':' . $method;
            
            $rbac = $identityManager->getRbac();
            
            $role = $identityManager->getIdentity();
            if (!$rbac->isGranted($role,$permission)){
                $event->getRouteMatch()->setParam('controller', 'menu');
                $event->getRouteMatch()->setParam('action', 'no-permission');
                error_log("$role has not permission to $permission");
            }            
        }
    }
}