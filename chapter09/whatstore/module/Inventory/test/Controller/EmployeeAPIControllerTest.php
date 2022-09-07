<?php

declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\EmployeeController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EmployeeAPIControllerTest extends AbstractHttpControllerTestCase
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

    public function testEmployeeInsert(): void
    {
        $_POST = [
            'ID' => 0,
            'name' => 'Jackson Heart',
            'nickname' => 'Jack of Hearts',
            'password' => 'Abc123@'
        ];
        $this->dispatch('/inventoryapi/employeeapi', 'POST', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('employeeapi'); // as specified in router's controller name alias
        $this->assertControllerClass('EmployeeAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testEmployeeRecover(): void
    {
        $name = strtoupper('Jackson Heart'); // field has filter StringToUpper
        $this->dispatch('/inventoryapi/employeeapi/' . $name, 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('employeeapi'); // as specified in router's controller name alias
        $this->assertControllerClass('EmployeeAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString($name, $body);
    }
    
    public function testEmployeeUpdate(): void
    {
        $employeeTable = $this->getApplication()->getServiceManager()->get('EmployeeTable');
        $employee = $employeeTable->getByField('name',strtoupper('Jackson Heart'));
        $employee->name = 'William Cody';
        $employee->nickname = 'Buffalo Bill';
        $_POST = $employee->toArray();
        $this->dispatch('/inventoryapi/employeeapi/' . $employee->ID, 'PUT', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('employeeapi'); // as specified in router's controller name alias
        $this->assertControllerClass('EmployeeAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testEmployeeDelete(): void
    {
        $employeeTable = $this->getApplication()->getServiceManager()->get('EmployeeTable');
        $employee = $employeeTable->getByField('nickname',strtoupper('Buffalo Bill'));
        $this->dispatch('/inventoryapi/employeeapi/' . $employee->ID, 'DELETE');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('employeeapi'); // as specified in router's controller name alias
        $this->assertControllerClass('EmployeeAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
}
