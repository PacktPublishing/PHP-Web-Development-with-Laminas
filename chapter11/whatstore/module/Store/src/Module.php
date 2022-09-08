<?php

declare(strict_types=1);

namespace Store;

use Laminas\Mvc\MvcEvent;
use Store\Listener\StoreAuthenticationListener;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
    
    public function onBootstrap($e)
    {
        if (defined('PHPUNIT_COMPOSER_INSTALL')) return;
        $application = $e->getApplication();
        $application->getEventManager()->attach(MvcEvent::EVENT_ROUTE,[StoreAuthenticationListener::class,'verifyIdentity']);        
    }
}
