<?php

declare(strict_types=1);

namespace StoreTest\Controller;

use Store\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ProductBasketControllerTest extends AbstractHttpControllerTestCase
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
        $this->dispatch('/store/productbasket', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('productbasket'); // as specified in router's controller name alias
        $this->assertControllerClass('ProductBasketController');
        $this->assertMatchedRouteName('store');
    }
}
