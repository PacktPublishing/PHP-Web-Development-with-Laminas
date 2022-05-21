<?php

declare(strict_types=1);

namespace Application;

use Laminas\Session\SessionManager;

class Module
{
    public function __construct()
    {
        if (SESSION_ENABLED){
            $sessionManager = new SessionManager();
            $sessionManager->start();
            error_log('Session enabled');
        }
    }
    
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}
