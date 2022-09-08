<?php

declare(strict_types=1);

namespace Inventory;

use Inventory\Listener\InventoryAuthenticationListener;
use Laminas\Mvc\MvcEvent;
use Inventory\Listener\InventoryAuthorizationListener;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
    
    /**
     * @param  \Laminas\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function onBootstrap($e)
    {
        if (defined('PHPUNIT_COMPOSER_INSTALL')) return;
        $application = $e->getApplication();
        $application->getEventManager()->attach(MvcEvent::EVENT_ROUTE,[InventoryAuthenticationListener::class,'verifyIdentity']);
        $application->getEventManager()->attach(MvcEvent::EVENT_ROUTE,[InventoryAuthorizationListener::class,'verifyPermission']);
    }  
}
