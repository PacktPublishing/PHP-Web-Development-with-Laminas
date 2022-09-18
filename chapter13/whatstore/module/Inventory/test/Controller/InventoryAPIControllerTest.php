<?php

declare(strict_types=1);

namespace InventoryTest\Controller;

use Inventory\Controller\InventoryController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Inventory\Model\Discount;
use Inventory\Model\Product;

class InventoryAPIControllerTest extends AbstractHttpControllerTestCase
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

    private function insertProduct(): void
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
        $product = new Product();
        $data = [
            'code' => 0,
            'name' => 'Cosmic Cube',
            'price' => 5642,
            'code_discount' => $discount->code
        ];        
        $product->exchangeArray($data);        
        $productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $productTable->save($product);
    }
    
    private function deleteProduct(): void
    {
        $productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $product = $productTable->getByField('name',strtoupper('Cosmic Cube'));
        $productTable->delete($product->code);        
        $discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
        $discount = $discountTable->getByField('name',strtoupper('no discount'));
        $discountTable->delete($discount->code);
    }
    
    public function testInventoryRecover(): void
    {
        $this->insertProduct();
        $productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $product = $productTable->getByField('name',strtoupper('Cosmic Cube'));
        $this->dispatch('/inventoryapi/inventoryapi/' . $product->code, 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('inventoryapi'); // as specified in router's controller name alias
        $this->assertControllerClass('InventoryAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString($product->name, $body);
    }
    
    public function testInventoryUpdate(): void
    {
        $productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $product = $productTable->getByField('name',strtoupper('Cosmic Cube'));
        $_POST = [
            'operation' => 'add',
            'amount' => 500
        ];
        $this->dispatch('/inventoryapi/inventoryapi/' . $product->code, 'PUT', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('inventory');
        $this->assertControllerName('inventoryapi'); // as specified in router's controller name alias
        $this->assertControllerClass('InventoryAPIController');
        $this->assertMatchedRouteName('inventoryapi');
        $inventoryTable = $this->getApplication()->getServiceManager()->get('InventoryTable');
        $inventory = $inventoryTable->getByField('code_product',$product->code);
        $this->assertEquals(500,$inventory->amount);
        $this->deleteProduct();
    }    
}
