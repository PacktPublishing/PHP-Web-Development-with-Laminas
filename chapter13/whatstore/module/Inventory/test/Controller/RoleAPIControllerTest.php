<?php

declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\RoleController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class RoleAPIControllerTest extends AbstractHttpControllerTestCase
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

    public function testRoleInsert(): void
    {
        $_POST = [
            'code' => 0,
            'name' => 'supervisor'
        ];
        $this->dispatch('/inventoryapi/roleapi', 'POST', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('roleapi'); // as specified in router's controller name alias
        $this->assertControllerClass('RoleAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testRoleRecover(): void
    {
        $name = strtoupper('supervisor'); // field has filter StringToUpper
        $this->dispatch('/inventoryapi/roleapi/' . $name, 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('roleapi'); // as specified in router's controller name alias
        $this->assertControllerClass('RoleAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString($name, $body);
    }
    
    public function testRoleRecoverAll(): void
    {
        $this->dispatch('/inventoryapi/roleapi', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('roleapi'); // as specified in router's controller name alias
        $this->assertControllerClass('RoleAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testRoleUpdate(): void
    {
        $roleTable = $this->getApplication()->getServiceManager()->get('RoleTable');
        $role = $roleTable->getByField('name',strtoupper('supervisor'));
        $role->name = 'consultor';
        $_POST = $role->toArray();
        $this->dispatch('/inventoryapi/roleapi/' . $role->code, 'PUT', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('roleapi'); // as specified in router's controller name alias
        $this->assertControllerClass('RoleAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testRoleDelete(): void
    {
        $roleTable = $this->getApplication()->getServiceManager()->get('RoleTable');
        $role = $roleTable->getByField('name',strtoupper('consultor'));
        $this->dispatch('/inventoryapi/roleapi/' . $role->code, 'DELETE');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('roleapi'); // as specified in router's controller name alias
        $this->assertControllerClass('RoleAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
}
