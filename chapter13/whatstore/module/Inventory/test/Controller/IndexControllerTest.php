<?php

declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp(): void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed(): void
    {
        $this->dispatch('/inventory', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('index'); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('inventory');
    }
    
    public function testLoginActionCanBeAccessed(): void
    {
        $_POST = [
            'nickname' => 'Jonn Jonnz',
            'password' => 'hronmeer'
        ];
        $this->dispatch('/inventory/index/login', 'POST', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('index'); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('inventory');
    }
    
    public function testLogoutActionCanBeAccessed(): void
    {
        $this->dispatch('/inventory/index/logout', 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('inventory');
        $this->assertControllerName('index'); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('inventory');
    }
}
