<?php

declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\DiscountController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class DiscountAPIControllerTest extends AbstractHttpControllerTestCase
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

    public function testDiscountInsert(): void
    {
        $_POST = [
            'code' => 0,
            'name' => 'no discount',
            'operator' => '-',
            'factor' => 0
        ];
        $this->dispatch('/inventoryapi/discountapi', 'POST', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('discountapi'); // as specified in router's controller name alias
        $this->assertControllerClass('DiscountAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testDiscountRecover(): void
    {
        $name = strtoupper('no discount'); // field has filter StringToUpper
        $this->dispatch('/inventoryapi/discountapi/' . $name, 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('discountapi'); // as specified in router's controller name alias
        $this->assertControllerClass('DiscountAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString($name, $body);
    }
    
    public function testDiscountUpdate(): void
    {
        $discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
        $discount = $discountTable->getByField('name','no discount');
        $discount->name = 'null discount';
        $discount->operator = '/';
        $discount->factor = 1;        
        $_POST = $discount->toArray();
        $this->dispatch('/inventoryapi/discountapi/' . $discount->code, 'PUT', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('discountapi'); // as specified in router's controller name alias
        $this->assertControllerClass('DiscountAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testDiscountDelete(): void
    {
        $discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
        $discount = $discountTable->getByField('name','null discount');
        $this->dispatch('/inventoryapi/discountapi/' . $discount->code, 'DELETE');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('discountapi'); // as specified in router's controller name alias
        $this->assertControllerClass('DiscountAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
}
