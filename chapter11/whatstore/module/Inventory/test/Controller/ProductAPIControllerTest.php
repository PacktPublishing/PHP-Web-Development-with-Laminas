<?php

declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\ProductController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Inventory\Model\Discount;

class ProductAPIControllerTest extends AbstractHttpControllerTestCase
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

    public function testProductInsert(): void
    {
        $discount = new Discount();
        $data = [
            'code' => 0,
            'name' => 'no discount',
            'operator' => '-',
            'factor' => 0
        ];
        $discount->exchangeArray($data);
        $discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
        $discountTable->save($discount);        
        $discount = $discountTable->getByField('name',strtoupper('no discount'));
        $_POST = [
            'code' => 0,
            'name' => 'Cosmic Cube',
            'price' => 5642,
            'code_discount' => $discount->code
        ];
        $this->dispatch('/inventoryapi/productapi', 'POST', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('productapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testProductRecover(): void
    {
        $name = strtoupper('Cosmic Cube');
        $this->dispatch('/inventoryapi/productapi/' . $name, 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('productapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString($name, $body);
    }
    
    public function testProductUpdate(): void
    {
        $productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $product = $productTable->getByField('name','Cosmic Cube');
        $product->name = 'Infinity Gauntlet';
        $product->price = 9654;
        $_POST = $product->toArray();
        $this->dispatch('/inventoryapi/productapi/' . $product->code, 'PUT', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('productapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductAPIController');
        $this->assertMatchedRouteName('inventoryapi');
    }
    
    public function testProductDelete(): void
    {
        $productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $product = $productTable->getByField('name','Infinity Gauntlet');
        $this->dispatch('/inventoryapi/productapi/' . $product->code, 'DELETE');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('productapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
        $discount = $discountTable->getByField('name','no discount');
        $discountTable->delete($discount->code);
    }
}
