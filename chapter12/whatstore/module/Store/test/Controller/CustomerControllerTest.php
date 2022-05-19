<?php

declare(strict_types=1);

namespace StoreTest\Controller;

use Store\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CustomerControllerTest extends AbstractHttpControllerTestCase
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
        $this->dispatch('/store/customer', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('customer'); // as specified in router's controller name alias
        $this->assertControllerClass('CustomerController');
        $this->assertMatchedRouteName('store');
    }
    
    public function testRegisterActionCanBeAccessed(): void
    {
        $this->dispatch('/store/customer/register', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('customer'); // as specified in router's controller name alias
        $this->assertControllerClass('CustomerController');
        $this->assertMatchedRouteName('store');
    }
    
    public function testLoginActionCanBeAccessed(): void
    {
        $_POST = [
            'email' => 'misterbliss@tolkien.com',
            'password' => 'toybears'
        ];
        $this->dispatch('/store/customer/login', 'POST', $_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('customer'); // as specified in router's controller name alias
        $this->assertControllerClass('CustomerController');
        $this->assertMatchedRouteName('store');
    }
    
    public function testLogoutActionCanBeAccessed(): void
    {
        $this->dispatch('/store/customer/logout', 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('store');
        $this->assertControllerName('customer'); // as specified in router's controller name alias
        $this->assertControllerClass('CustomerController');
        $this->assertMatchedRouteName('store');
    }
}
