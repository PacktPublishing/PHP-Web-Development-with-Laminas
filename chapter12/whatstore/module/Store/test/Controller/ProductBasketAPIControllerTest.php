<?php

declare(strict_types=1);

namespace StoreTest\Controller;

use Store\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ProductBasketAPIControllerTest extends AbstractHttpControllerTestCase
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

    public function testCreate(): void
    {
        $_POST = [
            'code' => 1,
            'name' => 'Soccer ball',
            'price' => 12,
            'amount' => 1
        ];
        $this->dispatch('/storeapi/productbasketapi', 'POST',$_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('productbasketapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductBasketAPIController');
        $this->assertMatchedRouteName('storeapi');
    }

    public function testGet(): void
    {
        $this->dispatch('/storeapi/productbasketapi/1', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('productbasketapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductBasketAPIController');
        $this->assertMatchedRouteName('storeapi');
        $body = $this->getResponse()->getBody();
    }
    
    public function testUpdate(): void
    {
        $_POST = [
            'operation' => 'add',
        ];
        $this->dispatch('/storeapi/productbasketapi/1', 'PUT', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('productbasketapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductBasketAPIController');
        $this->assertMatchedRouteName('storeapi');
    }
    
    public function testDelete(): void
    {
        $this->dispatch('/storeapi/productbasketapi/1', 'DELETE');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('productbasketapi'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductBasketAPIController');
        $this->assertMatchedRouteName('storeapi');
    }
}
