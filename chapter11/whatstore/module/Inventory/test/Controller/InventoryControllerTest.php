<?php
declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Inventory\Controller\ProductController;

class InventoryControllerTest extends AbstractHttpControllerTestCase
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
        $this->dispatch('/inventory/inventory', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('inventory'); // as specified in router's controller name alias
        $this->assertControllerClass('InventoryController');
        $this->assertMatchedRouteName('inventory');
    }
    
    public function testEditActionCanBeAccessed(): void
    {
        $this->dispatch('/inventory/inventory/edit', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('inventory'); // as specified in router's controller name alias
        $this->assertControllerClass('InventoryController');
        $this->assertMatchedRouteName('inventory');
    }
}
