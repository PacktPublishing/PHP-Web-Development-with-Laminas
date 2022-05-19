<?php

declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\ResourceController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ResourceAPIControllerTest extends AbstractHttpControllerTestCase
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

    public function testResourceInsert(): void
    {
        $_POST = [
            'code' => 0,
            'name' => 'index.index',
            'method' => 'GET'
        ];
        $this->dispatch('/inventoryapi/resourceapi', 'POST', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('resourceapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ResourceAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testResourceRecover(): void
    {
        $name = 'index.index';
        $this->dispatch('/inventoryapi/resourceapi/' . $name, 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('resourceapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ResourceAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString($name, $body);
    }
    
    public function testResourceRecoverAll(): void
    {
        $this->dispatch('/inventoryapi/resourceapi', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('resourceapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ResourceAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testResourceUpdate(): void
    {
        $resourceTable = $this->getApplication()->getServiceManager()->get('ResourceTable');
        $resource = $resourceTable->getByField('name','index.index');
        $resource->name = 'menu.index';
        $_POST = $resource->toArray();
        $this->dispatch('/inventoryapi/resourceapi/' . $resource->code, 'PUT', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('resourceapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ResourceAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testResourceDelete(): void
    {
        $resourceTable = $this->getApplication()->getServiceManager()->get('ResourceTable');
        $resource = $resourceTable->getByField('name','menu.index');
        $this->dispatch('/inventoryapi/resourceapi/' . $resource->code, 'DELETE');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('resourceapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ResourceAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
}
