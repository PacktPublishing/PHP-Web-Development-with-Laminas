<?php
namespace Generic\Context;

use Behat\Behat\Context\Context;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Mvc\Application;

abstract class AbstractContext implements Context
{
    protected function getApplication()
    {
        $appConfig = require __DIR__ . '/../../../../config/application.config.php';
        if (file_exists(__DIR__ . '/../../../../config/development.config.php')) {
            $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../../../../config/development.config.php');
        }
        
        return Application::init($appConfig);
    }
}

